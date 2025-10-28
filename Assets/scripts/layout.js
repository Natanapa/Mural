const slidesData = <?php echo json_encode($slides, JSON_UNESCAPED_UNICODE); ?>;
function editSlide(i){
    const s = slidesData[i] || {title:'',content:''};
    document.getElementById('formIndex').value = i;
    document.getElementById('titleInput').value = s.title;
    document.getElementById('contentInput').value = s.content;
    updatePreview();
}
function clearForm(){
    document.getElementById('formIndex').value = 0;
    document.getElementById('titleInput').value = '';
    document.getElementById('contentInput').value = '';
    document.getElementById('formAction').value = 'add';
    updatePreview();
}
function updatePreview(){
    document.getElementById('pvTitle').textContent = document.getElementById('titleInput').value;
    document.getElementById('pvContent').textContent = document.getElementById('contentInput').value;
}
document.getElementById('titleInput').addEventListener('input', updatePreview);
document.getElementById('contentInput').addEventListener('input', updatePreview);
// init
if(slidesData.length>0) editSlide(0);