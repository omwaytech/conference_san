<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\{MemberType, Conference, MemberTypePrice};
use Illuminate\Http\Request;
use Exception, DB, Batch;

class MemberTypePriceController extends Controller
{
    public function index()
    {
        $latestConference = Conference::latestConference();

        if (!empty($latestConference)) {
            $condition = "WHERE conference_id = " . $latestConference->id;
        } else {
            $condition = "";
        }

        $sql = "SELECT
                    MT.id,
                    MT.type,
                    MT.delegate,
                    MTP.price_id,
                    MTP.conference_id,
                    MTP.member_type_id,
                    MTP.early_bird_amount,
                    MTP.regular_amount,
                    MTP.on_site_amount,
                    MTP.guest_amount
                FROM member_types AS MT
                LEFT JOIN
                    (SELECT
                        id AS price_id,
                        conference_id,
                        member_type_id,
                        early_bird_amount,
                        regular_amount,
                        on_site_amount,
                        guest_amount
                    FROM
                        member_type_prices
                        $condition
                    ) AS MTP ON MT.id = MTP.member_type_id";

        $memberTypes = DB::select($sql);
        return view('backend.member-type.price.show', compact('memberTypes', 'latestConference'));
    }

    public function update(Request $request)
    {
        try {
            $latestConference = Conference::latestConference();

            if (empty($latestConference)) {
                return redirect()->back()->withInput()->with('delete', 'Please add conference at first to add members price.');
            }

            $insertArray = [];
            $updateArray = [];
            foreach ($request->member_type_id as $key => $value) {
                if (empty($request->price_id[$key])) {
                    $array['conference_id'] = $latestConference->id;
                    $array['member_type_id'] = $value;
                    $array['early_bird_amount'] = $request->early_bird_amount[$key];
                    $array['regular_amount'] = $request->regular_amount[$key];
                    $array['on_site_amount'] = $request->on_site_amount[$key];
                    $array['guest_amount'] = $request->guest_amount[$key];
                    $array['created_at'] = now();
                    $array['updated_at'] = now();
                    $insertArray[] = $array;
                } else {
                    $updatedDataArray['id'] = $request->price_id[$key];
                    $updatedDataArray['conference_id'] = $latestConference->id;
                    $updatedDataArray['member_type_id'] = $value;
                    $updatedDataArray['early_bird_amount'] = $request->early_bird_amount[$key];
                    $updatedDataArray['regular_amount'] = $request->regular_amount[$key];
                    $updatedDataArray['on_site_amount'] = $request->on_site_amount[$key];
                    $updatedDataArray['guest_amount'] = $request->guest_amount[$key];
                    $updatedDataArray['updated_at'] = now();
                    $updateArray[] = $updatedDataArray;
                }
            }
            if (!empty($insertArray)) {
                MemberTypePrice::insert($insertArray);
            }

            if (!empty($updateArray)) {
                Batch::update(new MemberTypePrice, $updateArray, 'id');
            }

            if (empty($updateArray)) {
                return redirect()->back()->with('status', 'Price Submitted successfully');
            } else {
                return redirect()->back()->with('status', 'Price Updated successfully');
            }

        } catch (Exception $e) {
            throw $e;
        }
    }
}
