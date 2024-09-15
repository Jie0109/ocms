window.onload = function(){
    document.getElementById("download")
    .addEventListener("click", () => {
        const content = this.document.getElementById("content");
        const id = this.document.getElementById("rids").innerHTML;
        console.log(content);
        console.log(window);
        var strName = id + '.pdf';
        const opt = {
            filename: strName
        };
        html2pdf().from(content).set(opt).save();
    })
}