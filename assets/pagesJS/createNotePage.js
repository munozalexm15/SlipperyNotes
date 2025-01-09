
import bulmaCalendar from 'bulma-calendar/dist/js/bulma-calendar.min';

let yesterdayDate = new Date();
yesterdayDate.setDate(yesterdayDate.getDate() - 1);

let reminderDate = document.getElementById("reminderDateField").getAttribute('data-reminder-date');
let reminderDateFormatted = new Date(reminderDate);

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
    weekStart: 1,
    showButtons: false,
};

if (reminderDate != null && reminderDate.length > 0) {
    console.log("HOLA'")
    defaultOptions["startTime"] = reminderDateFormatted;
    defaultOptions["startDate"] = reminderDateFormatted;
}

// Initialize all input of date type.
const calendars = bulmaCalendar.attach('[type="date"]', defaultOptions);