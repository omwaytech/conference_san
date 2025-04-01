<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitless">Poll</h5>
        <div class="d-flex justify-content-end">
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
        </div>
    </div>
    <div class="modal-body">
        @foreach ($polls as $poll)
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h6 class=" text-center">
                        {{ $poll->question_text }}
                    </h6>
                    @if ($poll->userHasVoted)
                        <!-- Show poll results -->

                        <div>

                            <div id="resultsContainer">
                                @foreach ($poll->poll_results as $result)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $result['answer_text'] }}</span>
                                            <span>{{ $result['percentage'] }}%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $result['percentage'] }}%"
                                                aria-valuenow="{{ $result['percentage'] }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div id="pollOptions" class="mt-4">
                            @foreach ($poll->answers as $answer)
                                <button class="btn btn-primary w-auto mb-2 poll-button"
                                    data-answer-id="{{ $answer->id }}" data-question-id="{{ $poll->id }}">
                                    {{ $answer->answer_text }}
                                </button>
                            @endforeach
                        </div>
                        <div id="pollResults" class="d-none">
                            <div id="resultsContainer">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".poll-button").click(function() {
            const answerId = $(this).data('answer-id');
            const pollId = $(this).data('question-id');

            const pollContainer = $(this).closest(".card");
            vote(answerId, pollId, pollContainer);
        });

        function vote(answerId, pollId, pollContainer) { 
            $.ajax({
                url: `{{ route('front.poll.vote') }}`,
                method: 'POST',
                data: {
                    answer_id: answerId,
                    poll_id: pollId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    const pollResults = response.poll_results;

                    displayResults(pollResults, pollContainer);
                },
                error: function(error) {
                    if (error.status === 403 && error.responseJSON?.error) {
                        toastr.error(error.responseJSON.error);
                    } else {
                        toastr.error('Something went wrong. Please try again later.');
                    }

                }
            });
        }

        function displayResults(results, pollContainer) {
            pollContainer.find('#pollOptions').hide();

            const pollResults = pollContainer.find('#pollResults');
            pollResults.removeClass('d-none');

            const resultsContainer = pollContainer.find('#resultsContainer');
            resultsContainer.empty();
            results.forEach(function(result) {
                console.log(result)
                const resultElement = `
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span>${result.answer_text}</span>
                    <span>${result.percentage}%</span>
                </div>
                <div class="progress">
                    <div 
                        class="progress-bar bg-success" 
                        role="progressbar" 
                        style="width: ${result.percentage}%" 
                        aria-valuenow="${result.percentage}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                    </div>
                </div>
            </div>`;
                resultsContainer.append(resultElement);
            });
        }
    });
</script>
