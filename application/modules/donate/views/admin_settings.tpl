<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12 mb-3">
        <div class="card">
        <header class="card-header">
            Value list <p class="pull-right" style="margin: 0px;">Value <i class="fa-solid fa-plus" style="cursor:pointer;" onClick="Donate.addValue(); return false"></i></p>
        </header>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Price</th>
                                <th>Points</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        {if $values}
                        <tbody id="value_list">
                            {foreach from=$values item=value}
                                <tr data-id="{$value.id}">
                                    <td>{$value.price}</td>
                                    <td>{$value.points}</td>
                                    <td class="text-center" width="50%">
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" onClick="Donate.updateValue({$value.id}, {$value.price}, {$value.points}); return false">Edit</a>
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" onClick="Donate.deleteValue({$value.id}, this); return false">Delete</a>
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                        {/if}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>