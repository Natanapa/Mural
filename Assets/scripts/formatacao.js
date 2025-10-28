function execCmd(command) {
    document.execCommand(command, false, null);
}
function execCmdWithArg(command, arg) {
    document.execCommand(command, false, arg);
}
function saveContent() {
    document.getElementById("hiddenInput").value = document.getElementById("editorArea").innerHTML;
}
function insertTable() {
    let rows = prompt("Quantas linhas?");
    let cols = prompt("Quantas colunas?");
    if (rows > 0 && cols > 0) {
        let table = "<table border='1' style='border-collapse:collapse; width:100%;'>";
        for (let i = 0; i < rows; i++) {
            table += "<tr>";
            for (let j = 0; j < cols; j++) {
                table += "<td style='padding:5px;'> </td>";
            }
            table += "</tr>";
        }
        table += "</table>";
        document.execCommand('insertHTML', false, table);   
    }
}