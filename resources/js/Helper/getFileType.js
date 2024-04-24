export function getFileType(extension){
    return extensionsList.get(extension)?? 'File'
}
const extensionsList = new Map()


// Text Files
extensionsList.set('doc','Word document')
extensionsList.set('docx','Word document')
extensionsList.set('eml','E-Mail message')
extensionsList.set('log','Log file')
extensionsList.set('txt','Text file')

//Audio Files
extensionsList.set('aif','Audio Interchange File')
extensionsList.set('m3u','M3U Media Playlist')
extensionsList.set('m4a','MPEG-4 Audio')
extensionsList.set('mid','MIDI File')
extensionsList.set('mp3','MP3 Audio')
extensionsList.set('wma','Windows Media Audio')


//Video Files
extensionsList.set('avi','AVI File')
extensionsList.set('flv','Flash Video')
extensionsList.set('m4v','iTunes Video File')
extensionsList.set('mov','Apple QuickTime Movie')
extensionsList.set('mp4','MPEG-4 Video')
extensionsList.set('mpg','MPEG Video')
extensionsList.set('wmv','Windows Media Video')

//Image files

extensionsList.set('png','Image')
extensionsList.set('jpg','Image')
extensionsList.set('psd','Adobe Photoshop')
extensionsList.set('dcm','Image')
extensionsList.set('bmp','Image')

extensionsList.set('ai','Adobe Illustrator')
extensionsList.set('svg','Image')
extensionsList.set('webp','Image')


//Archive files

extensionsList.set('zip','Archive')
extensionsList.set('7z','Archive')
extensionsList.set('rar','Archive')
extensionsList.set('rpm','Archive')
