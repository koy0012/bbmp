class DateHelper {

    constructor(config) {
        $(config.day).select2({ selectionCssClass: 'form-select' });
        $(config.month).select2({ selectionCssClass: 'form-select' });
        $(config.year).select2({ selectionCssClass: 'form-select' });
        $(config.month).change(() => this.dateChanged());
        $(config.year).change(() => this.dateChanged());

        this.optionCount = 0;
        this.config = config;
    }

    init() {
        this.daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        this.today = new Date();
        this.targetDate = new Date(
            this.today.getFullYear(),
            this.today.getMonth() + 1,
            this.today.getDate());

        this.setDate(this.targetDate);
        this.setYears(120)
    }

    dateChanged() {

        var monthIndex = $(this.config.month).val() - 1;
        this.setDays(monthIndex);
        $(this.config.day).trigger('change');
    }

    isLeapYear(year) {
        return (0 == year % 4) && (0 != year % 100) || (0 == year % 400);
    }

    setDate(date) {
        this.setDays(date.getMonth());
        $(this.config.day).val(date.getDate());
        $(this.config.month).val(date.getMonth());
        $(this.config.month).trigger('change');
        $(this.config.year).val(date.getFullYear());
    }

    setDays(monthIndex) {
        let daysCount = this.daysInMonth[monthIndex];

        if ($(this.config.month).val() == '2') {
            daysCount = this.isLeapYear($(this.config.year).val()) ? 28 : 29;

        }

        let prev = $(this.config.day).val();
 
        $(this.config.day).empty();
        for (var i = this.optionCount; i < daysCount; i++) {
            let s = "";
            if(prev <= daysCount && i+1 == prev){
                s = "selected";
            }

            $(this.config.day)
                .append($(`<option ${s}></option>`)
                    .attr("value", i + 1)
                    .text(i + 1));
        } 

        


    }

    setYears(val) {
        var year = this.today.getFullYear();
        for (var i = 0; i < val; i++) {
            $(this.config.year)
                .append($("<option></option>")
                    .attr("value", year - i)
                    .text(year - i));
        }
    }

}



