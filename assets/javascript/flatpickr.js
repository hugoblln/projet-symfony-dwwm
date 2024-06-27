flatpickr('.js-datepicker', {
    minDate: "today",
    maxDate: new Date().fp_incr(30), // 30 jours à partir d'aujourd'hui
    dateFormat: "Y-m-d"
});