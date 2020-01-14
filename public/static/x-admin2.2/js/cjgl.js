/**
  扩展cjgl模块
  **/      

layui.define(['table'],function(exports){ //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
    var table = layui.table;
    var obj = {

    // 新建弹窗
    add: function(title,url,width='',height='',max=false){
        xadmin.open(title,url,width,height,max);
    },

    // 删除单条记录
    del:function(obj,url){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                url:url+'/m',
                type:'DELETE',
                data:{
                    ids:obj.data.id
                },
                success:function(result){
                    if(result.val == 1)
                    {
                        obj.del();
                        layer.msg(result.msg);
                    }else{
                        layer.msg(result.msg,function(){});
                    }
                },
                error:function(result){
                    layer.msg('数据扔半道啦。',function(){});
                },
            });
        });
    },

    // 删除单条记录
    redel:function(obj,url){
        layer.confirm('确认要恢复删除吗？',function(index){
            $.ajax({
                url:url+'/'+obj.data.id,
                type:'DELETE',
                data:{
                    id:obj.data.id
                },
                success:function(result){
                    if(result.val == 1)
                    {
                        obj.del();
                        layer.msg(result.msg);
                    }else{
                        layer.msg(result.msg,function(){});
                    }
                },
                error:function(result){
                    layer.msg('数据扔半道啦。',function(){});
                },
            });
        });
    },

    // 删除全部
    delAll:function(obj,url,tableid){
        //判断是否选择数据
        if(obj.data.length==0){
            parent.layer.msg('请先选择要删除的数据行！',function(){});
            return ;
        }

        layer.confirm('确认要删除吗？',function(index){
            // 捉一下所有被选中的数据
            var ids = "";
            for(var i=0;i<obj.data.length;i++){
                if(i == 0){
                    ids= obj.data[i].id;
                }else{
                    ids= ids + "," + obj.data[i].id;
                }
            }
            // 到服务器去删除数据。
            $.ajax({
                url:url+'/m',
                type:'DELETE',
                data:{
                    ids:ids
                },
                success:function(result){
                    if(result.val == 1)
                    {
                        table.reload(tableid, {});
                        layer.msg(result.msg);
                    }else{
                        layer.msg(result.msg,function(){});
                    }
                },
                error:function(result){
                    layer.msg('数据扔半道，回不来啦。',function(){});
                },
            });
        });
    },

    // 设置状态
    status:function(obj,url){
        // 判断是禁用操作还是启用操作后赋值标题。

        var statusval;
        var title;
        if(obj.elem.checked ==true){
            statusval=1;
            title='启用';
        }else{
            statusval=0;
            title='禁用';
        }
        // console.log(url);
        // console.log(obj.elem);
        // 设置修改后的状态值
        layer.confirm('确认要'+title+'吗？',function(index){
            $.ajax({
                url:url,
                type:'POST',
                data:{
                    id:obj.elem.id,
                    value: statusval,
                },
                success:function(result){
                    if(result.val == 1){
                        // // 获取状态栏元素
                        // var myspan = $(obj.tr).find("span");
                        // // 获取状操作按钮元素
                        // var mya = $(obj.tr).find("[title='启用'],[title='禁用']");
                        // // 状态栏重新赋值
                        // myspan.text(title);
                        // // 重新设置状态栏class和状态操作按钮图标
                        // if(statusval == 1){
                        //     myspan.attr('class','layui-btn layui-btn-normal layui-btn-mini');
                        //     mya.attr("title",'启用');
                        // }else{
                        //     myspan.attr('class','layui-btn layui-btn-disabled layui-btn-mini');
                        //     mya.attr("title",'禁用');
                        // }
                        // 更新缓存值，否则下次操作会报错。
                        // obj.update({
                        //     status: 
                        // });
                        // obj.elem.prop('value','off');
                        // obj.elem.prop('checked',true);
                        // 操作提示
                        layer.msg('已'+title);
                    }else{
                        layer.msg('数据处理错误!',function(){});
                    }
                },
                error:function(result){
                    layer.msg('数据扔半道啦。',function(){});
                },
            });
        });
    },

    // 重置密码
    resetpassword:function(xingming,url){
        layer.confirm('确认要重置'+xingming+'的密码为“123456”吗？',function(index){
            $.ajax({
                url:url,
                type:'POST',
                success:function(result){
                    layer.msg(result.msg);
                },
                error:function(result){
                    layer.msg('数据扔半道啦。',function(){});
                },
            });
        });
    },
    // getSearchVal:function(name){
    //     // 声明对象，用于存表单名与数值
    //     var obj={};
    //     // 循环获取有表单的div
    //     $(name).children('div.layui-form-item').each(function(i){
    //         // 声明二级div
    //         var myblock = $(this).children('div.layui-input-block');
    //         var name=$(myblock).children("input:first").attr("name");
    //         // 判断二级div下的第一个input是不是text
    //         if($(myblock).children("input:first").attr("type") == 'text'){
    //             // 如果是文本框，则直接获取。
    //             var value=$(myblock).children('input').val();
    //             obj[name] = value;
    //         }else if($(myblock).children("input:first").attr("type") == 'checkbox'){
    //             // 如果是复选框，获取被选中的div
    //             var checkdiv = $(myblock).children("div.layui-form-checked");
    //             obj[name] = new Array();
    //             $(checkdiv).each(function(cd){
    //                 var value = $(this).prev('input').val();
    //                 obj[name].push(value);
    //             });
    //         }else if($(myblock).children("input:first").attr("type") == 'radio'){
    //              var checkdiv = $(myblock).children("div.layui-form-radioed");
    //              var value = $(checkdiv).prev('input').val();
    //              obj[name] = value;
    //         }
    //     });
    //     return obj;
    //   },

    // 表格重载
    reLoadTable:function(formname,tableID,mydata={}){
        var formval = this.getSearchVal(formname);
        var wheredata = $.extend(formval,mydata);
        table.reload(tableID,{
            where: formval
            ,done:function(){
                for(x in formval){
                    delete this.where[x];
                }
            }
            ,page:{
                curr:1
            }
        });
    },

    // Select获取焦点
    selectOnfocus:function(myobj,val,addname){
        // 声明变量
        var srcInput = $(myobj);
        // 删除原来列表
        srcInput.next().remove();

        // 添加列表div
        srcInput.after('<div class="srcSelectStyly"><dl><dd onclick="cjgl.addTeacher(this)">请选择</dd></dl></div>');
        // 声明变量
        var mydl = srcInput.next().children('dl');

        // 获取数据
        $.post(
            "/renshi/teacher/srcteacher",
            {
                "str":val,
            },
            function(data,status){
                
                if($.isEmptyObject(data))
                {
                    return true;
                }

                for (var i = data.length - 1; i >= 0; i--) {
                    mydl.append('<dd id="'+data[i].id+'" onclick="cjgl.addTeacher(this)" addname='+addname+' teachername="'+data[i].xingming+'">'+data[i].xingming+'　'+data[i].jsDanwei.jiancheng+'　'+data[i].shengri+'</dd>');
                }
                
            }
        );
    }, 

    // 添加教师
    addTeacher:function(myobj){
        var myId = $(myobj).attr('id')
            ,teachername = $(myobj).attr('teachername')
            ,addname = $(myobj).attr('addname')
            ,myTitle = $(myobj).text()
            ,myList = $(myobj).parent().parent()
            ,myBut = $(myList).parent().parent();

        if(myId){
            $(myBut).append('<div class="layui-input-inline" style="width:60px"><div onclick="cjgl.delTeacher(this)" class="layui-btn layui-btn-normal">'+teachername+'</div><input type="hidden" name="'+addname+'" value="'+myId+'"></div>');
        }

        $(myList).prev().val('');
        $(myList).remove();
    },

    // Select获取焦点
    selectOnfocus1:function(myobj,val,addname){
        // 声明变量
        var srcInput = $(myobj);
        // 删除原来列表
        srcInput.next().remove();

        // 添加列表div
        srcInput.after('<div class="srcSelectStyly"><dl><dd onclick="cjgl.addTeacher1(this)">请选择</dd></dl></div>');
        // 声明变量
        var mydl = srcInput.next().children('dl');

        // 获取数据
        $.post(
            "/renshi/teacher/srcteacher",
            {
                "str":val,
            },
            function(data,status){
                
                if($.isEmptyObject(data))
                {
                    return true;
                }

                for (var i = data.length - 1; i >= 0; i--) {
                    mydl.append('<dd id="'+data[i].id+'" onclick="cjgl.addTeacher1(this)" addname='+addname+' teachername="'+data[i].xingming+'">'+data[i].xingming+'　'+data[i].jsDanwei.jiancheng+'　'+data[i].shengri+'</dd>');
                }
                
            }
        );

          
    }, 

    // 添加教师
    addTeacher1:function(myobj){
        var myId = $(myobj).attr('id')
            ,teachername = $(myobj).attr('teachername')
            ,addname = $(myobj).attr('addname')
            ,myTitle = $(myobj).text()
            ,myList = $(myobj).parent().parent()
            ,myBut = $(myList).parent().parent();

        $(myList).prev().val(myId);
        $(myList).remove();
    },

    // 删除教师
    delTeacher:function(myobj){
        $(myobj).parent().remove();
    },
  };
  //输出test接口
  exports('cjgl', obj);
});