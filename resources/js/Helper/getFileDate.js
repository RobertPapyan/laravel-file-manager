export function getFileDate(timestamp){

    const date = new Date(timestamp*1000)
    const seconds = date.getSeconds() < 10? '0'+date.getSeconds() : date.getSeconds();
    const minutes = date.getMinutes() <10? '0' + date.getMinutes() : date.getMinutes();
    const timeString = date.getHours() > 12 ? date.getHours() - 12 + ':'+minutes+':'+seconds + ' PM' :
        date.getHours() + ':'+minutes+':'+seconds + ' AM'

    return date.getDay() + '/' + date.getMonth() + '/' + date.getFullYear()+', ' + timeString;
}
