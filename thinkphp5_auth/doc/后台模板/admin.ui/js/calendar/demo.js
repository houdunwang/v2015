$(document).ready( function(){
  var cTime = new Date(), month = cTime.getMonth()+1, year = cTime.getFullYear();

	theMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

	theDays = ["S", "M", "T", "W", "T", "F", "S"];
    events = [
      [
        "5/"+month+"/"+year, 
        'Meet a friend', 
        '#', 
        '#fb6b5b', 
        'Contents here'
      ],
      [
        "8/"+month+"/"+year, 
        'Kick off meeting!', 
        '#', 
        '#ffba4d', 
        'Have a kick off meeting with .inc company'
      ],
      [
        "18/"+month+"/"+year, 
        'Milestone release', 
        '#', 
        '#ffba4d', 
        'Contents here'
      ],
      [
        "19/"+month+"/"+year, 
        'A link', 
        'https://github.com/blog/category/drinkup', 
        '#cccccc'
      ]
    ];
    $('#calendar').calendar({
        months: theMonths,
        days: theDays,
        events: events,
        popover_options:{
            placement: 'top',
            html: true
        }
    });
});