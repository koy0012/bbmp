import.meta.env.ACTIVE_PING;

$(document).ready(() => { 
    let ping = 30000;
    if(ACTIVE_PING != null && ACTIVE_PING != ""){
        ping = ACTIVE_PING;
    }
    
    function session(){
        $.ajax({
            url:`${BASE_URL}/ping`,
            type:"POST",
            complete:() => {
                setTimeout(() => {
                    session();
                },ping); 
            }
        });
    }
    
    session();
    
});