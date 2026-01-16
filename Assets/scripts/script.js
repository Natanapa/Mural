const modal = document.getElementById('modal');
const btn = document.getElementById('btnAbrir');
const fechar = document.getElementById('fechar');
const ocframe = document.getElementById('frame');

btn.onclick = () => {
    modal.style.display = 'block';
    stage.style.display = 'none';
}
fechar.onclick = () => {
    modal.style.display = 'none';
    stage.style.display = 'flex';
}
document.querySelectorAll('.image-box').forEach(el => {
    el.addEventListener('click', () => {
        const caminho = el.dataset.path;
        console.log('Imagem selecionada:', caminho);


        // Aqui futuramente você pode:
        // - salvar em sessão
        // - enviar via AJAX
        // - definir constante dinamicamente
        jpgconst.value = caminho;

        modal.style.display = 'none';
        stage.style.display = 'flex';
    });
});
