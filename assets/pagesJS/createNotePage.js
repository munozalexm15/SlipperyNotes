
import bulmaCalendar from 'bulma-calendar/dist/js/bulma-calendar.min';

let yesterdayDate = new Date();
yesterdayDate.setDate(yesterdayDate.getDate() - 1);

var defaultOptions = {
    color: 'primary',
    isRange: false,
    allowSameDayRange: true,
    lang: 'en-US',
    endDate: undefined,
    maxDate: null,
    disabledDates: [yesterdayDate],
    disabledWeekDays: undefined,
    highlightedDates: [],
    dateFormat: 'yyyy-MM-dd',
    timeFormat: 'HH:mm:ss',
    enableMonthSwitch: true,
    enableYearSwitch: true,
    displayYearsCount: 50,
    displayMode: 'dialog',
    type: 'datetime',
    validateLabel: 'Set reminder',
    showTodayButton: false,
    minDate: yesterdayDate,
    startDate: new Date(),
    weekStart: 1,
    showButtons: false,

};


// Initialize all input of date type.
const calendars = bulmaCalendar.attach('[type="date"]', defaultOptions);