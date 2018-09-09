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
	$('body').on('click','.ajax-search-form',function () {
		load = layer.load(2);
        data = $(this).parents("form").serialize();
        if(data)
        {
            data = data + '&'+$(this).attr('name')+'='+$(this).attr('value');
        }else{
            data = $(this).attr('name')+'='+$(this).attr('value')
        }
		$.ajax({
			type:"POST",
			data:data,
			success: function(data,status){
				if(typeof load!="undefined"){layer.close(load);}
				$("#ajax-data").html(data);
			}
		});
        return false;
    });

    $('#schoForm').ajaxForm({
        success: function(data){
			if (data.code == 1) {
				layer.alert(data.msg, {icon: 6}, function (index) {
					layer.close(index);
					window.location.reload();
				});
			} else {
				layer.alert(data.msg, {icon: 5}, function (index) {
					layer.close(index);
				});
			}
		},
        dataType: 'json'
    });
	$('.ajax-form').ajaxForm({
		beforeSubmit:function(){
			load = layer.load(1);
		},
        success: function(data){
			layer.close(load);
			if (data.code == 1) {
				layer.alert(data.msg, {icon: 6}, function (index) {
					window.location.reload();
					layer.close(index);
				});
			} else {
				layer.alert(data.msg, {icon: 5}, function (index) {
					layer.close(index);
				});
			}
		},
        dataType: 'json'
    });
	$('.ajax-form2').ajaxForm({
		beforeSubmit:function(){
			load = layer.load(1);
		},
        success: function(data){
			layer.close(load);
			if (data.code == 1) {
				layer.alert(data.msg, {icon: 6}, function (index) {
					window.location.href = data.url;
					layer.close(index);
				});
			} else {
				layer.alert(data.msg, {icon: 5}, function (index) {
					layer.close(index);
				});
			}
		},
        dataType: 'json'
    });
	$('.ajaxForm2').ajaxForm({
		success: function(data){
			if (data.code == 1) {
				$('.login_error').html(data.msg);
				window.location.href = data.url;
			} else {
				$('.login_error').html(data.msg);
				return false;
			}
		}, // 这是提交后的方法
		dataType: 'json'
	});
	/* textarea字数*/
    var textbox_text=$(".textbox").val();
    var textbox_counter=textbox_text.length;
    $(".textbox_num").text(textbox_counter);
	$(".textbox").on('blur keyup input',function(){
		var text=$(".textbox").val();
		var counter=text.length;
		$(".textbox_num").text(counter);
	});
});


(function(doc, win) {
	var docEl = doc.documentElement,
		resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
		recalc = function() {
			var clientWidth = docEl.clientWidth;
			if (!clientWidth) return;
			if (clientWidth >= 640) {
				docEl.style.fontSize = '100px'
			} else {
				docEl.style.fontSize = 100 * (clientWidth / 640) + 'px'
			}
		};
	if (!doc.addEventListener) return;
	win.addEventListener(resizeEvt, recalc, false);
	doc.addEventListener('DOMContentLoaded', recalc, false)
})(document, window);

function imgChange(obj1, obj2) {
	var file = document.getElementById("file");
	var imgContainer = document.getElementsByClassName(obj1)[0];
	var fileList = file.files;
	var input = document.getElementsByClassName(obj2)[0];
	var imgArr = [];
	for (var i = 0; i < fileList.length; i++) {
		var imgUrl = window.URL.createObjectURL(file.files[i]);
		imgArr.push(imgUrl);
		var img = document.createElement("img");
		img.setAttribute("src", imgArr[i]);
		var imgAdd = document.createElement("div");
		imgAdd.setAttribute("class", "z_addImg");
		imgAdd.appendChild(img);
		imgContainer.appendChild(imgAdd)
	};
	imgRemove()
};

function imgRemove() {
	var imgList = document.getElementsByClassName("z_addImg");
	var mask = document.getElementsByClassName("z_mask")[0];
	var cancel = document.getElementsByClassName("z_cancel")[0];
	var sure = document.getElementsByClassName("z_sure")[0];
	for (var j = 0; j < imgList.length; j++) {
		imgList[j].index = j;
		imgList[j].onclick = function() {
			var t = this;
			mask.style.display = "block";
			cancel.onclick = function() {
				mask.style.display = "none"
			};
			sure.onclick = function() {
				mask.style.display = "none";
				t.style.display = "none"
			}
		}
	}
};


