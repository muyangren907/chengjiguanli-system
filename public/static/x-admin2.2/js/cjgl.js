/**
  扩展cjgl模块
  **/

layui.define(['table'],function(exports){ //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
  var table = layui.table
  form = layui.form;
  var obj = {

    // 新建弹窗
    add: function(title,url,width='',height='',max=false){
      xadmin.open(title,url,width,height,max);
    },
    // 新建Tab
    addTab: function(title,url,max=false){
      parent.xadmin.add_tab(title,url,max);
    },

    // 删除单条记录
    del:function(obj,url){
      layer.confirm('确认要删除吗？',function(index){
        $.ajax({
          url:url + '/m',
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

    // 恢复单条记录
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
            url:url + '/m',
            type:'DELETE',
            data:{
              id:ids
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

    // 开关操作
    onoff:function(obj){
      title = obj.msg[1-obj.val.value];
      // 设置修改后的状态值
      layer.confirm('确认要修改成'+title+'吗？',function(index){
        $.ajax({
          url:obj.url,
          type:'POST',
          data:obj.val,
          success:function(result){
            if(result.val == 1){
              layer.msg('已修改成：'+title);
            }else{
              layer.msg(result.msg);
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
          var str;
          for (var i = data.length - 1; i >= 0; i--) {
            str = '';
            str = '<dd ';
            str = str + 'id=' + data[i].id + ' ';
            str = str + 'onclick="cjgl.addTeacher(this)"' + ' ';
            str = str + 'addname=' + addname + ' ';
            str = str + 'teachername=' + data[i].xingming + ' ';
            str = str + 'schoolID=' + data[i].jsDanwei.id + ' ';
            str = str + 'schoolName=' + data[i].jsDanwei.jiancheng +'>';
            str = str + data[i].xingming+'　'+data[i].jsDanwei.jiancheng+'　'+data[i].shengri;
            str = str + '</dd>';
            mydl.append(str);
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
      ,myBut = $(myList).parent().parent()
      ,schoolName =  $(myobj).attr('schoolName');
      console.log(myobj);
      if(myId){
        var str = '<div class="layui-input-inline" style="width:60px" title="'+schoolName+'"> ';
        str = str + '<div onclick="cjgl.delTeacher(this)" class="layui-btn layui-btn-normal">';
        str = str + teachername;
        str = str + '</div><input type="hidden" name="'+addname+'" value="'+myId+'"></div>'
        $(myBut).append(str);
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

    /**
    * 动太获取复选框列表并添加列表
    *
    * @access public
    * @param parentId 要添加checkbox的divID
    * @param array val post时需要的参数
    * @param url post地址
    * @param createName 新checkbox名
    * @param title 输出返回数组的列
    * @return array 返回类型
    */
    createCheckbox:function(parentId,val,url,createName,title='title'){
      $('#'+parentId).children().remove();
      $.post(
        url,
        val,
        function(data,status){
          if(data.count){
            cnt = data.count;
            mydata = data.data;
          }else{
            cnt = 0;
            mydata = Array();
          }

          if(cnt>0){
            $('#'+parentId).append('<input type="checkbox" value="" title="全选" lay-skin="primary" checkall="p">');
          }
          for(x in mydata){
            $('#'+parentId).append('<input type="checkbox" name="'+createName+'[]" value="'+mydata[x]['id']+'" title="'+mydata[x][title]+'" lay-skin="primary" checkall="c">');
          }
          form.render();
        }
        );
    },


    /**
    * 动太获取复选框列表并添加列表
    *
    * @access public
    * @param idd 要添加select的ID
    * @param array val post时需要的参数
    * @param url post地址
    * @param createName 新checkbox名
    * @param title 输出返回数组的列
    * @return array 返回类型
    */
    createSelectOption:function(id, val, url, cloval='id', cloname='title', checkval=null){
      $('#' + id).children().remove();
      $.post(
        url,
        val,
        function(data,status){
          cnt = data.count;
          mydata = data.data;
          if(cnt>0){
            $('#' + id).append('<option value="">请选择</option>');
          }
          for(x in mydata){
            if(mydata[x][cloval] == checkval)
            {
              $('#' + id).append('<option value=' + mydata[x][cloval] + ' selected>' + mydata[x][cloname] + '</option>');
            }else{
              $('#' + id).append('<option value=' + mydata[x][cloval] + '>' + mydata[x][cloname] + '</option>');
            }
          }
          form.render();
        }
      );
    },



    /**
    * 单击全选按钮，全部选中或取消选中后面的checkbox
    * 选中所有全部checkbox
    *
    * @access public
    * @param parentId 选中checkbox父级div的id
    * @param checked post时需要的参数
    * @return array 返回类型
    */
    checkboxAll:function(parentId,checked){
      if(checked==true)
      {
        $('#'+parentId).find("input[checkall='c']").prop('checked',true);
      }else{
        $('#'+parentId).find("input[checkall='c']").prop('checked',false);
      }
      form.render();
    },

    /**
    * 如果有选中的checkbox,那么就选中全选按钮，否则取消选中
    *
    * @access public
    * @param parentId 选中checkbox父级div的id
    * @return array 返回类型
    */
    checkboxParent:function(parentId){
      children = $('#'+parentId).find(".layui-form-checked").prev("input[checkall='c']");
      children = children.length;
      if(children==0)
      {
        $('#'+parentId).find("input[checkall='p']").prop('checked',false);
      }else{
        $('#'+parentId).find("input[checkall='p']").prop('checked',true);
      }
      form.render();
    },

    /**
    * 在创建角色中，选中类别时的动作
    *
    * @access public
    * @param id 选中复选框的ID
    * @param checked 选中复选框的状态
    * @return array 返回类型
    */
    checkedAuth:function(id,checed){
      obj = $('#p'+id).html();
      aa = $('#p'+id).find("input[type='checkbox']").prop('checked',checked);
      form.render();
    },

    /**
    * 成绩统计
    * @access public
    * @param id 选中复选框的ID
    * @param checked 选中复选框的状态
    * @return array 返回类型
    */
    tongjiCj:function(url,val){
      $.ajax({
        url:url,
        type:'POST',
        async: true,
        data:val,
        beforeSend: function () {
          $("body").append('<div id="load" style="position:fixed;top:30%;z-index:1200;background:url(__XADMIN__/images/timg.gif) top center no-repeat;width:100%;height:140px;margin:auto auto;"></div>');
        },
        complete: function () {
          $("#load").remove();
        },
        success:function(result){
          layer.msg(result.msg);
        },
        error:function(result){
          layer.msg('数据扔半道，回不来啦。',function(){});
        },
      });
    },



  };
  //输出test接口
  exports('cjgl', obj);
});
