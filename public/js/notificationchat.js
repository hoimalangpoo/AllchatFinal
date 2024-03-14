// $(document).ready(function() {
    
//     setInterval(function() {
        
//         $.ajax({
//             url: 'update_not_reply',
//             method: 'GET', 
//             dataType: 'json', 
//             success: function(response) {
            
//                 $.each(response, function(index, item) {
//                     console.log(item);
//                     var lineOAid = item.lineOAid;
//                     var not_reply = item.not_reply;

                
//                     $('#notReplyBadge' + lineOAid).text(not_reply);
//                 });
//             }
//         });
//     }, 5000);
// });
