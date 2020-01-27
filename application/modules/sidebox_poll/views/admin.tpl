<section class="box big" id="main_polls">
	<h2>
		Polls (<div style="display:inline;" id="polls_count">{if !$polls}0{else}{count($polls)}{/if}</div>)
	</h2>

	<span>
		<a class="nice_button" href="javascript:void(0)" onClick="Poll.add()">Create poll</a>
	</span>

	<ul id="polls_list">
		{if $polls}
			{foreach from=$polls item=poll}
				<li>
					<table width="100%">
						<tr>
							<td width="80%">{if isset($poll.active)}<span style="padding:0px;display:inline;color:green;">Current:</span> {/if}<b>{$poll.question}</b></td>
							<td style="text-align:right;">
								<a href="javascript:void(0)" onClick="Poll.remove({$poll.questionid}, this)" data-tip="Delete"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>
							</td>
						</tr>
					</table>
					<table width="100%">
						{if $poll.answers}
							{foreach from=$poll.answers item=answer}
								<tr>
									<td width="17%" style="padding-left:20px;">
										<b>{$answer.votes} ({if $answer.votes != 0 && $poll.total != 0}{round(($answer.votes / $poll.total) * 100)}{else}0{/if}%)</b>
									</td>
									<td>
										{$answer.answer}
									</td>
								</tr>
							{/foreach}
						{/if}
					</table>
				</li>
			{/foreach}
		{/if}
	</ul>

	<span>
		<center>To display the poll, please <b><a href="{$url}admin/sidebox">create the poll sidebox</a></b></center>
	</span>
</section>

<section class="box big" id="add_polls" style="display:none;">
	<h2><a href='javascript:void(0)' onClick="Poll.add()" data-tip="Return to polls">Polls</a> &rarr; New poll</h2>

	<form onSubmit="Poll.create(this); return false" id="submit_form">

		<label for="question">Question</label>
		<input type="text" name="question" id="question"/>

		<label>Answers (<a href="javascript:void(0)" onClick="Poll.addAnswer()">add more</a>)</label>
		<div id="answer_fields">
			<input type="text" name="answer_1" id="answer_1" placeholder="Answer 1"/>
			<input type="text" name="answer_2" id="answer_2" placeholder="Answer 2"/>
		</div>

		<input type="submit" value="Submit poll" />
	</form>
</section>