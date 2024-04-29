const notes = document.querySelectorAll('.star-ratings')


for (let note of notes) {
    let stars = ''
    const valeurNote = Math.ceil(parseFloat(note.dataset.note));
    for (i = 0; i < valeurNote; i++) {
        stars += '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 64 64"><path fill="#ffce31" d="M62 25.2H39.1L32 3l-7.1 22.2H2l18.5 13.7l-7 22.1L32 47.3L50.5 61l-7.1-22.2z" /></svg>'
    }
    for (let j = valeurNote; j < 5; j++) {
        stars += '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 64 64"><path fill="white" d="m61.13 23.718l-22.65-.105L31.583.692l-6.898 22.921l-22.651.105L20.423 38.35l-9.297 24.96l20.457-15.86L52.05 63.31l-9.308-24.96z"/><path fill="white" d="M53.09 26.904L38.48 24.22l-6.897-12.27l-6.898 12.27l-14.08 2.84l9.814 11.891l-2.572 15.85l13.732-6.751l14.11 6.903l-2.955-16z"/></svg>'
    }
    note.innerHTML = stars
}