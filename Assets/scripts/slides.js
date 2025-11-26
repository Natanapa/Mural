const slides = <?php echo json_encode($slides, JSON_UNESCAPED_UNICODE); ?>;
let idx = 0;
let timer = null;
function render(){
    const s = slides[idx] || {title:'',content:''};
    document.getElementById('sTitle').textContent = s.title || '';
    document.getElementById('sContent').textContent = s.content || '';
}
function next(){ idx = (idx + 1) % slides.length; render(); }
function prev(){ idx = (idx - 1 + slides.length) % slides.length; render(); }
function play(){
    if(timer){ clearInterval(timer); timer = null; document.getElementById('playBtn').textContent='Play'; return; }
    const sec = parseInt(document.getElementById('intervalSel').value,10) * 1000;
    timer = setInterval(next, sec);
    document.getElementById('playBtn').textContent='Pause';
}
render();
document.getElementById('nextBtn').addEventListener('click', next);
document.getElementById('prevBtn').addEventListener('click', prev);
document.getElementById('playBtn').addEventListener('click', play);