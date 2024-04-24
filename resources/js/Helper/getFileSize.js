export function getFileSize(size){
    const typesArray = ['Byte','KB','MB','GB','TB'];
    let typeNumber = 0;
    while(size/1024 > 1){
        typeNumber++;
        size/=1024;
    }
    size = size % 1 == 0 ? size : size.toFixed(2);
    return size +' '+ typesArray[typeNumber];
}
