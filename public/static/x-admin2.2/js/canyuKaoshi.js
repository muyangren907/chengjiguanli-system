/**
  扩展cjgl模块
  **/

layui.extend({
  // 根路径下的具体路径（xmSelect/xmSelect.js）
  xmSelect: "xm-select"
}).define(['table', 'form', 'xmSelect', 'upload'], function(exports) {
  //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
  var table = layui.table,
    form = layui.form,
    upload = layui.upload,
    xmSelect = layui.xmSelect;

  var obj = {
    gradeSelect: function(myid, kaoshi_id, hasNull = true) {
      $.ajax({
        url: '/kaoshi/kscy/grade',
        type: 'POST',
        data: {
          kaoshi_id: kaoshi_id
        },
        success: function(result) {
          if (hasNull == true) {
            str = '<option value=""></option>';
          } else {
            str = '';
          }
          temp = "";
          $(result.data).each(function(i, el) {
            if (value != '' && value == el.id) {
              temp = '<option value="' + el.id + '" selected>' + el.title + '</option>';
            } else {
              temp = '<option value="' + el.id + '">' + el.title + '</option>';
            }
            str = str + temp;
          });
          $('#' + myid).append(str);
          form.render('select');
        },
        error: function(result) {
          layer.msg('数据扔半道啦。', function() {});
        },
      });
    },


    // 参与本次考试学科
    subjectSelect: function(myid, kaoshi_id, ruxuenian, hasNull = true){
      $.ajax({
        url: '/kaoshi/kscy/subject',
        type: 'POST',
        data: {
          kaoshi_id: kaoshi_id,
          ruxuenian: ruxuenian
        },
        success: function(result) {
          if (hasNull == true) {
            str = '<option value=""></option>';
          } else {
            str = '';
          }
          temp = "";
          $(result.data).each(function(i, el) {
            if (value != '' && value == el.id) {
              temp = '<option value="' + el.id + '" selected>' + el.title + '</option>';
            } else {
              temp = '<option value="' + el.id + '">' + el.title + '</option>';
            }
            str = str + temp;
          });
          $('#' + myid).append(str);
          form.render('select');
        },
        error: function(result) {
          layer.msg('数据扔半道啦。', function() {});
        },
      });
    },

  };
  //输出test接口
  exports('canyuKaoshi', obj);
});
