const modal = document.getElementById('modal');
const btn = document.getElementById('btnAbrir');
const fechar = document.getElementById('fechar');
const ocframe = document.getElementById('frame');
const jpgcampo = document.getElementById('jpgconst');

btn.onclick = () => {
    modal.style.display = 'block';
    stage.style.display = 'none';
}
fechar.onclick = () => {
    modal.style.display = 'none';
    stage.style.display = 'flex';
}
document.querySelectorAll('.image-box').forEach(ele => {
    ele.addEventListener('click', () => {
        const caminho = ele.dataset.path;
        console.log('Imagem selecionada:', caminho);


        // Aqui futuramente você pode:
        // - salvar em sessão
        // - enviar via AJAX
        // - definir constante dinamicamente
        el.jpgconst.value = caminho;

        modal.style.display = 'none';
        stage.style.display = 'flex';
    });
});
