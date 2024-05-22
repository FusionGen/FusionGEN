<div class="card" id="main_polls">
	<div class="card-header">
		Polls (<div class="d-inline" id="polls_count">{if !$polls}0{else}{count($polls)}{/if}</div>)
		{if hasPermission("createPoll")}<button class="btn btn-primary btn-sm pull-right" onclick="Poll.add()">Create poll</button>{/if}
	</div>
	<div class="card-body">
		{if $polls}
			{foreach from=$polls item=poll}
			<div class="card-header mb-3">
					<table class="table table-borderless">
					<tbody>
						<tr>
							<td class="fw-bold">{if isset($poll.active)}<span class="text-success">Current:</span> {/if}{$poll.question}</td>
							<td class="text-center">
								<button class="btn btn-primary btn-sm pull-right" onClick="Poll.remove({$poll.questionid}, this)">Delete</button>
							</td>
						</tr>
					</tbody>
					</table>

					<div class="card-body table-responsive">
					<table class="table table-hover">
					<tbody>
						{if $poll.answers}
							{foreach from=$poll.answers item=answer}
								<tr>
									<td class="ps-5 fw-bold">
										{$answer.votes} ({if $answer.votes != 0 && $poll.total != 0}{round(($answer.votes / $poll.total) * 100)}{else}0{/if}%)
									</td>
									<td>
										{$answer.answer}
									</td>
								</tr>
							{/foreach}
						{/if}
					</tbody>
					</table>
					</div>
			</div>
			{/foreach}
		{/if}
		<div class="text-center">To display the poll, please <a class="fw-bold" href="{$url}admin/sidebox">create the poll sidebox</a></div>
	</div>
</div>

<div class="card d-none" id="add_polls">
	<div class="card-header">New poll</div>
	<div class="card-body">

	<form onSubmit="Poll.create(this); return false" id="submit_form">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="question">Question</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="question" id="question">
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label">Answers (<a href="javascript:void(0)" onClick="Poll.addAnswer()">add more</a>)</label>
		<div class="col-sm-10" id="answer_fields">
			<input class="form-control mb-3" type="text" name="answer_1" id="answer_1" placeholder="Answer 1">
			<input class="form-control mb-3" type="text" name="answer_2" id="answer_2" placeholder="Answer 2">
		</div>
		</div>

		<button type="submit" class="btn btn-primary btn-sm">Submit poll</button>
	</form>
	</div>
</div>
