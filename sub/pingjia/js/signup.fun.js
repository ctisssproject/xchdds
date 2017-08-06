function submit_search()
{
	if (document.getElementById("Vcl_Key").value == "") {
		if (document.getElementById("Vcl_H_Street").value == "") {
			window.alert("请选择 [幼儿园所在街道] ！")
			document.getElementById("Vcl_H_Street").focus()
			return
		}
	}
	show_load();
	setTimeout('document.getElementById("submit_form").submit();',5000)
}
function submit_search_forsetclass()
{
	if (document.getElementById("Vcl_Key").value == "") {
		if (document.getElementById("Vcl_H_Street").value == "") {
			window.alert("请选择 [幼儿园所在街道] ！")
			document.getElementById("Vcl_H_Street").focus()
			return
		}
	}
	show_load();
	setTimeout('document.getElementById("submit_form").submit();',5000)
}
function change_jiedao(obj)
{
	if (obj.value=="")
	{
		var s_html='<div><label>幼儿园所在社区</label><select id="Vcl_H_Shequ" name="Vcl_H_Shequ"><option value=""></option></select></div><div class="space10"></div>'
		document.getElementById("h_shequ").innerHTML=s_html
		return
	}
	var value=obj.value
	var a_shequ=JieDao[value];
	a_shequ.sort();
	var s_html='<div><label>幼儿园所在社区</label><select id="Vcl_H_Shequ" name="Vcl_H_Shequ"><option value=""></option>'
	for(var i=0;i<a_shequ.length;i++)
	{
		s_html=s_html+'<option value="'+a_shequ[i]+'">'+a_shequ[i]+'</option>'
	}
	s_html=s_html+'</select></div><div class="space10"></div>'
	document.getElementById("h_shequ").innerHTML=s_html
}
function delete_signup(id)
{
	var b=window.confirm("是否真的要取消这个报名？")
	if(b)
	{
		show_load();
		document.getElementById("Vcl_Id").value=id
		document.getElementById("submit_form").submit()
	}
}
