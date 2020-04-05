export default  {
    format_date(date) {
        let inputDate = new Date(date);
        return inputDate.toLocaleDateString('bg-BG', {
            day : 'numeric',
            month : 'short',
            year : 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        })
    },
    timeConvert(n) {
        let hours = (n / 60);
        let rhours = Math.floor(hours);
        let minutes = (hours - rhours) * 60;
        let rminutes = Math.round(minutes);

        return rhours ? rhours + " час(а) и " + rminutes + " минута(и)." : rminutes + " минута(и).";
    },
}
