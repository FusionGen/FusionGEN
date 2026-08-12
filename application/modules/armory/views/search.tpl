<div class="page-subbody mt-0 p-3">
    <form onSubmit="Search.show_data(); return false;">
        <div class="row g-2 gy-3 align-items-end justify-content-center justify-content-lg-start">
            
            <div class="col-12 col-md-6 col-lg-3">
                <select id="realm" name="realm">
                    <option value="0" disabled>{lang("realm", "armory")}</option>
                    {foreach from=$realms item=realm}
                        <option {if $realm@first}selected{/if} value="{$realm->getId()}">{$realm->getName()}</option>
                    {/foreach}
                </select>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <select id="table" name="table">
                    <option value="characters">{lang("characters", "armory")}</option>
                    <option value="guilds">{lang("guilds", "armory")}</option>
                    <option value="items">{lang("items", "armory")}</option>
                </select>
            </div>

            <div class="col-12 col-lg">
                <input type="search" id="search_field" name="search_field" placeholder="{lang("search_placeholder", "armory")}">
            </div>

            <div class="col-auto text-center mt-4">
                <button class="nice_button rounded text-nowrap" type="submit"><i class="fas fa-search"></i> {lang("search_button", "armory")}</button>
            </div>

        </div>
    </form>
</div>

<div class="page-subbody mt-3 p-3 table-responsive" id="search_box">
	<table class="nice_table" id="search_results_items">
        <thead>
            <tr>
				<th>{lang("name", "armory")}</th>
				<th>{lang("level", "armory")}</th>
				<th>{lang("required", "armory")}</th>
				<th>{lang("type", "armory")}</th>
			</tr>
        </thead>
        <tbody></tbody>
    </table>
    <table class="nice_table" id="search_results_characters">
        <thead>
            <tr>
				<th></th>
				<th>{lang("name", "armory")}</th>
				<th>{lang("faction", "armory")}</th>
				<th>{lang("level", "armory")}</th>
				<th></th>
			</tr>
        </thead>
        <tbody></tbody>
    </table>
    <table class="nice_table" id="search_results_guilds">
        <thead>
            <tr>
				<th>{lang("name", "armory")}</th>
				<th>{lang("members", "armory")}</th>
				<th>{lang("owner", "armory")}</th>
			</tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
