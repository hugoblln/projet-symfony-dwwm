// function removeCollectionForm(e) {
//     e.currentTarget.closest('li').remove()
// }


// function addFormToCollection(e) {
//     const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
  
//     const item = document.createElement('li');
//     item.classList.add('col-md-5')

    
  
//     item.innerHTML = collectionHolder
//       .dataset
//       .prototype
//       .replace(
//         /__name__/g,
//         collectionHolder.dataset.index
//       );

//     const bntRemove = document.createElement('button')
//     bntRemove.setAttribute('type', 'button')
//     bntRemove.classList.add('btn', 'btn-danger','btn-remove-collection')
//     bntRemove.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M18.36 19.78L12 13.41l-6.36 6.37l-1.42-1.42L10.59 12L4.22 5.64l1.42-1.42L12 10.59l6.36-6.36l1.41 1.41L13.41 12l6.36 6.36z"/></svg>'

//     item.prepend(bntRemove)
  
//     collectionHolder.appendChild(item);


//     bntRemove.addEventListener('click', removeCollectionForm)
  
//     collectionHolder.dataset.index++;
//   };

  


// document
//   .querySelectorAll('.add_item_link')
//   .forEach(btn => {
//       btn.addEventListener("click", addFormToCollection)
//   });

