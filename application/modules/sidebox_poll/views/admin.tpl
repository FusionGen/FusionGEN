<div class="card" id="main_polls">
	<div class="card-header">
		Polls (<div style="display:inline;" id="polls_count">{if !$polls}0{else}{count($polls)}{/if}</div>)
		{if hasPermission("createPoll")}<a class="btn btn-primary btn-sm pull-right" href="{$url}sidebox_poll/admin/new">Create poll</a>{/if}
	</div>
	<div class="card-body">
		{if $polls}
			{foreach from=$polls item=poll}
			<div class="card-header mb-3">
					<table class="table table-responsive-md">
					<tbody style="border-top:none;">
						<tr>
							<td>{if isset($poll.active)}<span style="padding:0px;display:inline;color:green;">Current:</span> {/if}<b>{$poll.question}</b></td>
							<td style="text-align:center;">
								<a class="btn btn-primary btn-sm pull-right" href="javascript:void(0)" onClick="Poll.remove({$poll.questionid}, this)">Delete</a>
							</td>
						</tr>
					</tbody>
					</table>
			
					<div class="card-body">
					<table class="table table-responsive-md table-hover">
					<tbody style="border-top:none;">
						{if $poll.answers}
							{foreach from=$poll.answers item=answer}
								<tr>
									<td style="padding-left:20px;">
										<b>{$answer.votes} ({if $answer.votes != 0 && $poll.total != 0}{round(($answer.votes / $poll.total) * 100)}{else}0{/if}%)</b>
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
	<span>
		<center>To display the poll, please <b><a href="{$url}admin/sidebox">create the poll sidebox</a></b></center>
	</span>
	</div>
</div>

<div class="card" id="add_polls" style="display:none;">
	<h2><a href='javascript:void(0)' onClick="Poll.add()">Polls</a> &rarr; New poll</h2>

	<form onSubmit="Poll.create(this); return false" id="submit_form">

		<label class="col-sm-2 col-form-label" for="question">Question</label>
		<input class="form-control" type="text" name="question" id="question"/>

		<label class="col-sm-2 col-form-label">Answers (<a href="javascript:void(0)" onClick="Poll.addAnswer()">add more</a>)</label>
		<div id="answer_fields">
			<input class="form-control" type="text" name="answer_1" id="answer_1" placeholder="Answer 1"/>
			<input class="form-control" type="text" name="answer_2" id="answer_2" placeholder="Answer 2"/>
		</div>

		<button type="submit" class="btn btn-primary btn-sm">Submit poll</button>
	</form>
</div>