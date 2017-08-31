function preview(oper)
{
    if (oper < 10)
    {
        bdhtml=window.document.body.innerHTML;//获取当前页的html代码
        sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域
        eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域
        prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html
        prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
        window.document.body.innerHTML=prnhtml;
        window.print();
        window.document.body.innerHTML=bdhtml;
    } else {
        window.print();
    }
}

$(function () {
    $("body").on("change",".upfile",function () {
        // $(this).parent().next().text("");//将存放文件名的容器置空
        $(this).parent().parent().next().find(".upfile_name").text("");//将存放文件名的容器置空
        var filearr=$(this).get(0).files;//将文件DOM对象转化为JQ对象
        for(var i=0;i<filearr.length;i++) {
            var fileSize=filearr[i].size;//获取文件大小，单位为字节
            var extStart=filearr[i].name.lastIndexOf(".");//获取文件名中“.”后面的内容，后缀名
            var ext=filearr[i].name.substring(extStart,filearr[i].name.length).toUpperCase();
            if(fileSize/(1024*1024)>2) {
                alert("文件大小超出限制，请重新选择！");
                $(this).attr("value","");
                return false;
            }
            if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG") {
                alert("文件格式错误，请重新选择！");
                $(this).attr("value","");
                return false;
            }
            if($(this).get(0)=='') return false;//检测是否为空，点击后没选择返回false
            var serial=i+1;
            // $(this).parent().next().append(serial+"、"+"<u>"+filearr[i].name+"</u>"+"；")//输出文件名

            $(this).parent().parent().next().find(".upfile_name").append(serial+"、"+"<u>"+filearr[i].name+"</u>"+"；")//输出文件名
        }

    })
});


