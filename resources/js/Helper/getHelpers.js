export function getContent(disk = 'public',path = '',chunk = 0){
    return  fetch(route('fm.content')+`?disk=${disk}`+`&path=${path}`+`&chunk=${chunk}`, {
         headers:{
             'Content-Type': 'application/json',
             'Accept' : 'application/json',
         },


     }).then(response => response.json())
 }

 export function getTree(disk = 'public',path = ''){
    return  fetch(route('fm.tree')+`?disk=${disk}`+`&path=${path}`, {
         headers:{
             'Content-Type': 'application/json',
             'Accept' : 'application/json',
         },


     }).then(response => response.json())
 }


 export function getInit(){
    return  fetch(route('fm.initialize'), {
        headers:{
            'Content-Type': 'application/json',
            'Accept' : 'application/json',
        },
    }).then(response => response.json())
}

export function getSearch(search,disk = 'public',chunk = 0){
   return  fetch(route('fm.search')+`?search=${search}&disk=${disk}&chunk=${chunk}`,{
        headers:{
            'Content-Type': 'application/json',
            'Accept' : 'application/json',
        },
       }).then(response => response.json())
}
