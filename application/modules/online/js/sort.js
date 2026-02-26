var Sort = {
    nameASC: true,
    levelASC: true,
    locationASC: true,

    name: function(realm) {
        var tbody = $("#online_realm_" + realm + " table tbody");
        tbody.find("tr").sort(function(a, b) {
            var aVal = $(a).find("td:nth-child(1)").text().trim();
            var bVal = $(b).find("td:nth-child(1)").text().trim();
            return Sort.nameASC
                ? aVal.localeCompare(bVal)
                : bVal.localeCompare(aVal);
        }).appendTo(tbody);

        Sort.nameASC = !Sort.nameASC;
    },

    level: function(realm) {
        var tbody = $("#online_realm_" + realm + " table tbody");
        tbody.find("tr").sort(function(a, b) {
            var aVal = parseInt($(a).find("td:nth-child(4)").text(), 10) || 0;
            var bVal = parseInt($(b).find("td:nth-child(4)").text(), 10) || 0;
            return Sort.levelASC
                ? aVal - bVal
                : bVal - aVal;
        }).appendTo(tbody);

        Sort.levelASC = !Sort.levelASC;
    },

    location: function(realm) {
        var tbody = $("#online_realm_" + realm + " table tbody");
        tbody.find("tr").sort(function(a, b) {
            var aVal = $(a).find("td:nth-child(5)").text().trim();
            var bVal = $(b).find("td:nth-child(5)").text().trim();
            return Sort.locationASC
                ? aVal.localeCompare(bVal)
                : bVal.localeCompare(aVal);
        }).appendTo(tbody);

        Sort.locationASC = !Sort.locationASC;
    }
};
