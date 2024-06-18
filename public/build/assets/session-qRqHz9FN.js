$(document).ready(()=>{let e=3e4;ACTIVE_PING!=null&&ACTIVE_PING!=""&&(e=ACTIVE_PING);function n(){$.ajax({url:`${BASE_URL}/ping`,type:"POST",complete:()=>{setTimeout(()=>{n()},e)}})}n()});
