<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollAnswer;
use Exception;
use Illuminate\Http\Request;
use Mavinoo\Batch\Batch;

class PollController extends Controller
{
    public function index()
    {
        $id = request('id');
        $polls = Poll::whereStatus(1)->where('scientific_session_id', $id)->get();
        return view('backend.poll.index', compact('id', 'polls'));
    }

    public function create($id)
    {
        return view('backend.poll.create', compact('id'));
    }

    public function store(Request $request)
    {
        try {
            foreach ($request->questions as $questionData) {
                $question = Poll::create([
                    'scientific_session_id' => $request->scientific_session_id,
                    'question_text' => $questionData['question_text'],
                ]);

                foreach ($questionData['answers'] as $answer) {
                    $question->answers()->create([
                        'answer_text' => $answer['answer_text'],
                        'is_correct' => isset($answer['is_correct']) ? $answer['is_correct'] : 0,
                    ]);
                }
            }

            return redirect()->route('poll.index', $request->scientific_session_id)->with('status', 'Poll Added Successfully');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function edit($id)
    {
        $poll = Poll::whereId($id)->first();

        return view('backend.poll.create', compact('poll'));
    }

    public function update(Request $request, $id, Batch $batch)
    {
        // dd($request->all());
        try {
            $req = $request->all();
            $poll = Poll::whereId($id)->first();
            $poll->update($req);

            $studentEducationDetail = [];
            $ids = $request->input('id');

            foreach ($request->answer_text as $key => $answer_text) {
                $studentEducationDetail[] = [
                    'answer_text' => $answer_text,
                    'id' => $ids[$key],
                ];
            }

            $batch->update(new PollAnswer(), $studentEducationDetail, 'id');

            return redirect()->route('poll.index', $id)->with('status', 'Poll Edited Successfully');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function destroy($id)
    {
        try {
            $poll = Poll::whereId($id)->first();
            $poll->update([
                'status' => 0
            ]);
            return redirect()->route('poll.index', $id)->with('status', 'Poll Deleted Successfully');
        } catch (\Exception $e) {
            dd($e);
            //throw $th;
        }
    }
}
