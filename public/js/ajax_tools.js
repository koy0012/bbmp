
//requires jquery
class AjaxTools {
    constructor(config) {
        this.config = config;

        if (!this.config.hasOwnProperty('message')) {
            this.config.message = {};
            this.config.message.success = "Success";
            this.config.message.fail = "Invalid Data";
            this.config.message.error = "Error";
        } else if (!this.config.message.hasOwnProperty('success')) {
            this.config.message.success = 'Success';
        } else if (!this.config.message.hasOwnProperty('fail')) {
            this.config.message.fail = 'Invalid Data';
        } else if (!this.config.message.hasOwnProperty('error')) {
            this.config.message.error = 'Error';
        }

    }

    validate() {
        $(this.config.target).find("[role='alert']").remove();
        return this.validator.form();
    }

    init() {
        let config = this.config;
        let instance = this;

        this.isLoading = false;


        this.loading = `<span class="loading loading-spinner loading-xs"></span>`;

        $(config.target).submit((e) => {
            e.preventDefault();
        });

        let validator = $(config.target).validate({
            ignore: config?.ignore ?? "",
            rules: config.rules,
            invalidHandler: function (event, validator) {
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();

                console.log(validator.errorList);

                if (errors) {
                    $(config.target).find("[role='alert']").remove();
                    $(config.target).prepend(instance.alertError(config.message.fail));
                }
            },
            submitHandler: (form) => {

                if (instance.isLoading) {
                    console.log('pending request');
                    return;
                }

                if(typeof config?.preRequest === 'function' && !(config?.preRequest(form) ?? false)){
                    return;
                }

                instance.isLoading = true;
                $(form).find("[role='alert']").remove();
                $(form).find("[type='submit']").attr("disabled");
                $(form).find("[type='submit']").append(this.loading);

                let ajax = config.ajax(form);

                if (!ajax.hasOwnProperty('complete')) {
                    ajax.complete = () => {
                        instance.isLoading = false;
                        $(form).find("[type='submit']").removeAttr("disabled");
                        $(form).find("[type='submit'] .loading").remove();
                    };
                }

                if (!ajax.hasOwnProperty('error')) {
                    ajax.error = (e) => {
                        ajax?.cbError(e);
                        if (e.status == 422) {
                            try {
                                validator.showErrors(e.responseJSON.errors);
                            } catch (ex) {
                                // console.error(ex);
                            }
                            $(form).prepend(instance.alertError(e.responseJSON?.message ?? config.message.fail));
                        } else if(e?.responseJSON?.hasOwnProperty('message') ?? false){
                            $(form).prepend(instance.alertError(e.responseJSON?.message ?? config.message.fail));
                        } 
                        else {
                            $(form).prepend(instance.alertError(e.status + " unable to process your request"));
                        }
                    }
                }

                if (!ajax.hasOwnProperty('success')) {
                    ajax.success = (e) => {
                        if (e?.success ?? false) {
                            $(form).prepend(instance.alertSuccess(config.message.success));

                            if (config?.reset) {
                                $(form).trigger("reset");
                            }

                            ajax?.cbSuccess(e);
                        } else {
                            validator.showErrors(e?.errors ?? []);
                            $(form).prepend(instance.alertError(config.message.fail));
                            ajax?.cbError(e);
                        }

                    }
                }

                $.ajax(ajax);
            }
        });

        this.validator = validator;

        return this;
    }

    alertSuccess(message) {
        return `<div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
          <span class="font-medium pl-1">${message}</span> 
        </div>
      </div>`;
    }

    alertError(message) {
        return `<div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
          <span class="font-medium  pl-1">${message}</span>
        </div>
      </div>`;
    }
}



