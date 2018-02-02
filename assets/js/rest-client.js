function groupJsonArray (arr, groupFields)
{
	var groupedArr = new Object();
	arr.forEach(function (row) 
	{
		var group = groupedArr;
		for (var i = 0; i < groupFields.length; i++)
		{
			var fieldName = groupFields[i];
			var groupValue = row[fieldName];
			
			let initProperty = !group.hasOwnProperty(groupValue);
			if (i == (groupFields.length-1))
			{
				if (initProperty)
					group[groupValue] = [];
				
				group[groupValue].push(row);
			}
			else
			{
				if (initProperty)
					group[groupValue] = new Object();
				
				group = group[groupValue];
			}
		}
	});	
	
	return groupedArr;
}