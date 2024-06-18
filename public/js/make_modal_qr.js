function makeModalQR(id, title, message, confirm_cb, decline_cb = null) {

    let cleanUp = () => {
        $(document).off('click', `#${id}-decline`);
        $(document).off('click', `#${id}-confirm`);
        $(`#${id}-modal`).remove();
    }

    let btn_decline = "";

    $(document).on('click', `#${id}-confirm`, () => {
        confirm_cb();
        cleanUp();
    });

    if (typeof decline_cb === 'function') {
        $(document).on('click', `#${id}-decline`, () => {
            decline_cb();
            cleanUp();
        });

        btn_decline = ` <button id='${id}-decline' data-modal-hide="popup-modal" type="button" class="text-white bg-red-800 hover:bg-stone-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
    CANCEL
</button>`;
    } else {
        //do nothing
    }

    let modal = `<div id="${id}-modal" tabindex="-1" class="overflow-y-auto fixed overflow-x-hidden top-0 right-0 left-0 z-50 flex bg-slate-600 bg-opacity-75 justify-center items-center w-full md:inset-0 h-screen max-h-full">
<div class="relative p-4 w-full max-w-md max-h-full">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="p-4 md:p-5 text-center flex justify-center flex-col items-center"> 
            <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">${title}</h3>
            <img src="${message}"/>
            <div class='flex flex-col lg:flex-row gap-1'>
            <button id='${id}-confirm' data-modal-hide="popup-modal" type="button" class="text-white text-center bg-stone-800 hover:bg-stone-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">OK </button>
            <a href='${message}' target='_blank' data-uri='${message}' data-name='${title}' class='fn-download text-white text-center bg-stone-800 hover:bg-stone-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 me-2'>Download</a>
            </div>
            ${btn_decline}
        </div>
    </div>
</div>
</div>`;

    $('body').append(modal);
}