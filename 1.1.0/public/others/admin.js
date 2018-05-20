// 调查问卷增添删改按钮
$(function () {
    $("body").on("click",".ques_b_remove",function () {
        $(this).closest(".ques_module").remove()
    })


    $("body").on("click",".ques_b_add",function () {
        var name = $(this).parents(".ques_b_title").find("input").eq(0).attr("name");
        var $ques_b=$("<div class=\"ques_m_title\">\n" +
            "    <input type=\"text\" value=\"\" name="+name+">\n" +
            "    <div class=\"control_btn\">\n" +
            "        选择类型：\n" +
            "        <select class=\"form-control\">\n" +
            "            <option value='radio'>单项选择</option>\n" +
            "            <option value='checkbox'>多项选择</option>\n" +
            "            <option value='text'>文本框</option>\n" +
            "        </select>\n" +
            "        <a class=\"btn btn-info btn-sm ques_m_add\">添加子类</a>\n" +
            "        <a class=\"btn btn-success btn-sm\" onclick='addZ($(this))'>点击修改</a>\n" +
            "        <a class=\"btn btn-danger btn-sm ques_m_remove\">删除本项</a>\n" +
            "    </div>\n" +
            "    <ul class=\"ques_m_option\">\n" +
            "    </ul>\n"+
            "</div>")
        $(this).closest(".ques_module").append($ques_b)
    });



    $("body").on("click",".ques_m_remove",function () {
        $(this).closest(".ques_m_title").remove()
    })



    $("body").on('click','.ques_m_add',function(){
        var name = $(this).parents(".ques_m_title").find('input').eq(0).attr('name');
        var $ques_m=$("<li>\n" +
            "                            <input type=\"text\" value=\"\" name='"+name+"'>\n" +
            "                            <div class=\"control_btn\">\n" +
            "                                <a class=\"btn btn-success btn-sm\" onclick='addX($(this))'>点击修改</a>\n" +
            "                                <a class=\"btn btn-danger btn-sm ques_s_remove\">删除本项</a>\n" +
            "                            </div>\n" +
            "                        </li>")
        $(this).parent(".control_btn").next().append($ques_m)
    });
    $("body").on("click",".ques_s_remove",function () {
        $(this).closest(".ques_m_option>li").remove();
    })
    $("body").on("click",".ques_type_add",function () {
        $(this).before("<div class=\"ques_module\">\n" +
            "    <div class=\"ques_b_title\">\n" +
            "        <input type=\"text\" value=\"\">\n" +
            "        <div class=\"control_btn\">\n" +
            "            <a class=\"btn btn-info btn-sm ques_b_add\">添加子类</a>\n" +
            "            <a class=\"btn btn-success btn-sm\" onclick='addD($(this))'>点击修改</a>\n" +
            "            <a class=\"btn btn-danger btn-sm ques_b_remove\">删除本项</a>\n" +
            "        </div>\n" +
            "    </div>\n" +
            "    <div class=\"ques_m_title\">\n" +
            "    </div>\n" +
            "</div>")
    })
});
// 打印
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
//班级审核
// $(function () {
//     $(".audit_opera>.btn-danger").bind("click",function () {
//         $(this).next().attr("disabled",true)
//     });
//     $(".audit_opera>.btn-success").bind("click",function () {
//         $(this).next().removeAttr("disabled");
//         $(this).prev().attr("disabled",true)
//     })
// });
//学生处查看院系评定情况
// $(function () {
//     //评估系统班级小组下拉框
//     $(".class_select").change(function () {
//         $(".passed>.success_bg>span").html("");
//         $(".passed>.danger_bg>span").html("");
//         var classVal=$(".class_select").find("option:selected").val();
//         if (classVal==0) {
//             $(".passed>.success_bg").html("评定通过人数：");
//             $(".passed>.danger_bg").html("评定未通过人数：");
//         }else if (classVal==1 || classVal==2) {
//             $(".passed>.success_bg").html("班级已评定人数：");
//             $(".passed>.danger_bg").html("班级未评定人数：");
//         }else if (classVal==3 || classVal==4){
//             $(".passed>.success_bg").html("院系已评定人数：");
//             $(".passed>.danger_bg").html("院系未评定人数：");
//         }
//     });
//     //评估系统辅导员下拉框
//     $(".counselor_sub").change(function () {
//         var counselorSub=$(".counselor_sub").find("option:selected").text();
//         $(".passed>.success_bg>span:first-child").html(counselorSub);
//         $(".passed>.danger_bg>span:first-child").html(counselorSub)
//     });
//     //评估系统院系小组下拉框
//     $(".faculty_grade").change(function () {
//         var facultyGrade=$(".faculty_grade").find("option:selected").text();
//         $(".passed>.success_bg>span:first-child").html(facultyGrade);
//         $(".passed>.danger_bg>span:first-child").html(facultyGrade)
//     });
//     $(".faculty_sub").change(function () {
//        var facultySub=$(".faculty_sub").find("option:selected").text();
//         $(".passed>.success_bg>span:nth-child(2)").html(facultySub);
//         $(".passed>.danger_bg>span:nth-child(2)").html(facultySub)
//     });
//     $(".faculty_pass").change(function () {
//         var facultyPass=$(".faculty_pass").find("option:selected").val();
//         if(facultyPass==0) {
//             $(".passed>.success_bg>span:nth-child(3)").html("已评定人数：");
//             $(".passed>.danger_bg>span:nth-child(3)").html("未评定人数：")
//         }else if (facultyPass==1) {
//             $(".passed>.success_bg>span:nth-child(3)").html("班级已评定：");
//             $(".passed>.danger_bg>span:nth-child(3)").html("班级未评定：")
//         }else if (facultyPass==2) {
//             $(".passed>.success_bg>span:nth-child(3)").html("院系已评定：");
//             $(".passed>.danger_bg>span:nth-child(3)").html("院系未评定：")
//         }
//     });
//     //评估系统学生处下拉框
//     // $(".manage_grade").change(function () {
//     //    var manageGrade=$(".manage_grade").find("option:selected").text();
//     //     $(".passed>.success_bg>span:first-child").html(manageGrade);
//     //     $(".passed>.danger_bg>span:first-child").html(manageGrade)
//     // });
//     // $(".manage_fac").change(function () {
//     //     var manageFac=$(".manage_fac").find("option:selected").text();
//     //     $(".passed>.success_bg>span:nth-child(2)").html(manageFac);
//     //     $(".passed>.danger_bg>span:nth-child(2)").html(manageFac)
//     // });
//     // $(".manage_sub").change(function () {
//     //     var manageSub=$(".manage_sub").find("option:selected").text();
//     //     $(".passed>.success_bg>span:nth-child(3)").html(manageSub);
//     //     $(".passed>.danger_bg>span:nth-child(3)").html(manageSub)
//     // });
//     // $(".manage_pass").change(function () {
//     //     var managePass=$(".manage_pass").find("option:selected").val();
//     //     if(managePass==0){
//     //         $(".passed>.success_bg>span:nth-child(4)").html("全院已评定");
//     //         $(".passed>.danger_bg>span:nth-child(4)").html("全院未评定")
//     //     }else if(managePass==1) {
//     //         $(".passed>.success_bg>span:nth-child(4)").html("院系已评定");
//     //         $(".passed>.danger_bg>span:nth-child(4)").html("院系未评定")
//     //     }
//     // });
//     $(".manage_fac_sta").change(function () {
//         var manageFacsta=$(".manage_fac_sta").find("option:selected").text();
//         $(".passed>.success_bg>span:nth-child(5)").html("（"+manageFacsta+"）");
//         $(".passed>.danger_bg>span:nth-child(5)").html("（"+manageFacsta+"）")
//     });
//     //三金系统下拉框
//     $(".subject_select").change(function () {
//         $(".passed>.success_bg>span:nth-child(2)").html("");
//         $(".passed>.danger_bg>span:nth-child(2)").html("");
//         //获取下拉框被选中项的文本内容
//         var subjectText=$(".subject_select").find("option:selected").text();
//         $(".passed>.success_bg>span:nth-child(2)").html(subjectText);
//         $(".passed>.danger_bg>span:nth-child(2)").html(subjectText);
//     });
//     $(".grade_select").change(function () {
//         $(".passed>.success_bg>span:nth-child(1)").html("");
//         $(".passed>.danger_bg>span:nth-child(1)").html("");
//         var gradeText=$(".grade_select").find("option:selected").text();
//         $(".passed>.success_bg>span:nth-child(1)").html(gradeText);
//         $(".passed>.danger_bg>span:nth-child(1)").html(gradeText);
//     })
//     $(".grade_select ").change(function(){
//         var gradeVal1=$(".grade_select option:selected").val();
//         var subjectVal1=$(".subject_select option:selected").val();
//         console.log(gradeVal1+subjectVal1);
//         $.post("",{
//             grade:gradeVal1,
//             profession:subjectVal1,
//             type:1,
//             faculty:5
//         },function (data) {
//             data=JSON.parse(data);
//             var passed=data.all_pass;
//             var nopass=data.not_pass;
//             $(".personal_num>.passed:nth-child(1)>.default_bg>span").html(passed);
//             $(".personal_num>.passed:nth-child(2)>.default_bg>span").html(nopass)
//         })
//     });
//     $(".subject_select").change(function(){
//         var gradeVal2=$(".grade_select option:selected").val();
//         var subjectVal2=$(".subject_select option:selected").val();
//         $.post("/admin/FacultyGroup/ajaxForFaculty",{
//             grade:gradeVal2,
//             profession:328,
//             type:1,
//             faculty:3
//         },function (data) {
//             data=JSON.parse(data);
//             var passed=data.all_pass;
//             var nopass=data.not_pass;
//             $(".personal_num>.passed:nth-child(1)>.default_bg>span").html(passed);
//             $(".personal_num>.passed:nth-child(2)>.default_bg>span").html(nopass)
//         })
//     });
//     $(".grade_select ").change(function(){
//         var gradeVal1=$(".grade_select option:selected").val();
//         var subjectVal1=$(".faculty_select option:selected").val();
//         console.log(gradeVal1+subjectVal1);
//         $.post("",{
//             grade:gradeVal1,
//             profession:subjectVal1,
//             type:2,
//             faculty:5
//         },function (data) {
//             data=JSON.parse(data);
//             var passed=data.all_pass;
//             var nopass=data.not_pass;
//             $(".personal_num>.passed:nth-child(1)>.default_bg>span").html(passed);
//             $(".personal_num>.passed:nth-child(2)>.default_bg>span").html(nopass)
//         })
//     });
//     $(".faculty_select").change(function(){
//         var gradeVal2=$(".grade_select option:selected").val();
//         var subjectVal2=$(".faculty_select option:selected").val();
//         $.post("/admin/FacultyGroup/ajaxForFaculty",{
//             grade:gradeVal2,
//             profession:533,
//             type:2,
//             faculty:5
//         },function (data) {
//             data=JSON.parse(data);
//             var passed=data.all_pass;
//             var nopass=data.not_pass;
//             $(".personal_num>.passed:nth-child(1)>.default_bg>span").html(passed);
//             $(".personal_num>.passed:nth-child(2)>.default_bg>span").html(nopass)
//         })
//     });
// });
// 修改评分增减
$(function () {
    $("body").on("click",".modify_add",function () {
        var scoreAdd=Number($(this).prev().val());
        $(this).prev().val(scoreAdd+1)
    });
    $("body").on("click",".modify_less",function () {
        var scoreLess=Number($(this).next().val());
        $(this).next().val(scoreLess-1)
    });
});
// 查看相关证明
$(function(){
    $(".photo li").on("click",function(){
        var i = $(this).index(".photo li");
        $(".photo_all").fadeIn(200);
        go(i);
    });

    var p_num = $(".photo_all ul li").length;
    var cid=0;
    $(".page_p").on("click",function(){
        go("prev")
    });
    $(".page_n").on("click",function(){
        go("next")
    });
    $(".page_box li").on("click",function(){
        go($(this).index(".page_box li"))
    });
    $(".close").on("click",function(){
        $(".photo_all").fadeOut(200)
    });
    function go(arg){
        var n = arg;
        if(!isNaN(n)){
            $(".photo_all_box ul li").stop().eq(n).animate({"opacity":1}).siblings("li").animate({"opacity":0})
            cid = n;
        }else if(n == "next"){
            cid = ++cid > p_num-1 ? p_num-1 : cid ;
            $(".photo_all_box ul li").eq(cid).animate({"opacity":1}).siblings("li").animate({"opacity":0})

        }else if(n == "prev"){
            cid = --cid < 0 ? 0 : cid ;
            $(".photo_all_box ul li").eq(cid).animate({"opacity":1}).siblings("li").animate({"opacity":0})
        }
        pagew(cid)
    }
    function pagew(x){
        var x = x;
        var left =  -102*x;
        console.log(left);
        console.log(p_num*52 );
        left = -left < 299 ? 0 : -left > p_num*52 ? -p_num*52+180: left+299;
        console.log(x);

        $(".page_box ol").stop().animate({
            "left": left
        });
        $(".page_box ol li").eq(x).addClass("on").siblings("li").removeClass("on")
    }
});


