const DeleteDialog = {
  install(Vue, { MessageBox }) {
    Vue.prototype.$deleteDialog = (
      message,
      callback,
      promptValue = '',
      promptLabel = ''
    ) => {
      if (promptValue && promptValue.length > 0) {
        MessageBox.prompt(
          '<h3>您确定吗?</h3><div>' + message + ' 将被删除.</div>',
          {
            showClose: false,
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            iconClass: 'el-icon-remove',
            customClass: 'delete-dialog',
            dangerouslyUseHTMLString: true,
            center: true,
            callback: callback,
            inputPlaceholder: promptLabel,
            inputValidator: value => {
              return promptValue === value
            },
            inputErrorMessage: promptLabel + '不匹配'
          }
        )
      } else {
        MessageBox.confirm(
          '<h3>您确定吗?</h3><div>' + message + ' 将被删除.</div>',
          {
            showClose: false,
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            iconClass: 'el-icon-remove',
            customClass: 'delete-dialog',
            dangerouslyUseHTMLString: true,
            center: true,
            callback: callback
          }
        )
      }
    }
  }
}

export default DeleteDialog
