function confirmRemoval(user,username) {        
  $( "#confirm-dialog" ).dialog({
    resizable: false,
    modal: true,
    dialogClass: "no-close",
    width: 380,
    buttons: {
      "Ja, ta bort användare": function() {
        //alert("Tar bort användare " + user);
        $.delete_(Config.url+"/user/:"+username, {}, function(data){
          console.log(data);
        });

        $( this ).dialog( "close" );
      },
      "Nej, behåll användare": function() {
        $( this ).dialog( "close" );
      }
    }
  });
}