import { Wheel } from "spin-wheel";

$(document).ready(() => {

    // 1. Configure the wheel's properties:

    var interval = null;
    var auto_spin_interval = null;

    var tada_sfx = new Audio('/audio/games/tada.mp3');

    var ticks = [
        new Audio('/audio/games/tick1.mp3'),
        new Audio('/audio/games/tick2.mp3'),
        new Audio('/audio/games/tick3.mp3')
    ];

    let tick = 0;

    const props = {
        items: [],
        overlayImage: "/img/games/raffle.svg",
        onCurrentIndexChange: (evt) => {
            try {
                tick++;
                if (tick >= ticks.length) {
                    tick = 0;
                }

                ticks[tick].play();
            }catch(ex){
                console.error(ex);
            }
        },
        onSpin: (evt) => {
            wheel.isInteractive = false;
            if(interval != null){
                return;
            }

            interval = setInterval(() => {
                if(wheel.rotationSpeed == 0 && interval != null){ 
                    stopWheel(); 
                    tada_sfx.play();

                    let item = getCurrentItem(wheel.getCurrentIndex());
                    
                    makeModal("raffle_winner",`Congratulations to ${item.label}, registry: ${item.misc.province}, ${item.misc.municipal} `, () => {
                        loadUsers(); 
                        //uncomment this if you want to see their info right after 
                        // window.open("/back/user/" + item.misc.id, "_blank","width=500,height=500")
                    }); 
                }
            },500);
        }
    }

    

    function getCurrentItem(index){
        return props.items[index];
    }


    // 2. Decide where you want it to go:
    const container = document.querySelector('.wheel-container');
    var wheel;
    // 3. Create the wheel in the container and initialise it with the props:
    if(container != null && container != undefined){
        wheel = new Wheel(container, props);
        
    }else {
        //don't load raffle
        return;
    }
    
    $(".spin-raffle").click((e) => {
        let duration = $(e.currentTarget).attr("data-duration"); 
        spin(duration);
    });

    function spin(duration){  
        wheel.rotationResistance = 0;
        let lastSpin = getRandomNumber(10,250);
        wheel.spin(250);
        auto_spin_interval = setTimeout(() => {
            wheel.spin(lastSpin);
            wheel.rotationResistance = -35;
        },duration);
    }

    function getRandomNumber(min, max){
        return Math.floor(Math.random() * (max - min) + min);
    }

    $("#select-raffle-filter").click(() => {
        stopWheel();
        loadUsers();
    });

    $("#select-raffle-stop").click(() => {
        stopWheel();
    });

    $("#select-raffle-clear").click(() => { 
        stopWheel();
        $("#provincial-select").val("");
        $("#provincial-select").trigger("change");
        $("#group-select").val("");
        $("#group-select").trigger("change");
        loadUsers();
    });

    function stopWheel(){
        wheel.rotationResistance = -35;
        wheel.isInteractive = true;
        clearInterval(interval);
        interval = null;

        if(auto_spin_interval != null){
            clearInterval(auto_spin_interval);
            auto_spin_interval = null;
        }
       
        wheel.stop();
    }
 

    function loadUsers(){
        $.ajax({
            url:"/back/games/getActive",
            data: {
                "province_id": $("#provincial-select").val() ?? "",
                "municipal_id": $("#municipal-select").val() ?? "",
                "groups": $("#group-select").val() 
            },
            success:(evt) => { 
                var i = 0;
                
                props.items = [];
                evt.forEach(element => {
                    props.items.push({
                        label:element.name,
                        backgroundColor: (i % 2 == 0) ? "#fff" : "#f00",
                        misc:element
                    });

                    i++;
                });

                wheel.init(props);
            }
        }); 
    }

    loadUsers();
});