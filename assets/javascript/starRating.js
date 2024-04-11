const notes = document.querySelectorAll('.star-ratings')


for(let note of notes) {
     let stars = ''
    const valeurNote = parseFloat(note.dataset.note);
    for(i=0;i<valeurNote;i++) {
        stars +='⭐'
    }
    note.textContent = stars
}