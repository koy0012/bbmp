 <div class="text-2xl">Location</div>
 <div class="w-full grid lg:grid-cols-3 grid-cols-1 gap-3 mb-3">
     <select class=" " id="provincial-select" name="municipal_id"></select>
     <select class=" " id="municipal-select" name="municipal_id"></select>
     <select class=" " id="group-select" name="municipal_id" multiple="multiple"></select>

 </div>
 <div class="d-flex">
     <button class="btn btn-success filter" id="select-raffle-filter">Filter</button>
     <button class="btn btn-success filter" id="select-raffle-clear">Clear</button>
     <button class="btn btn-success filter" id="select-raffle-stop">Stop</button>
     <button class="btn btn-success filter spin-raffle" data-duration="60000">Spin 1m</button>
     <button class="btn btn-success filter spin-raffle" data-duration="180000">Spin 3m</button>
     <button class="btn btn-success filter spin-raffle" data-duration="300000">Spin 5m</button>
 </div>

 <div class="wheel-container h-full w-full"></div>