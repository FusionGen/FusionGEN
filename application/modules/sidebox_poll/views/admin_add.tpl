<div class="card">
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
