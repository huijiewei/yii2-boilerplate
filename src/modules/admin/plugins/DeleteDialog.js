const DeleteDialog = {
  install(Vue, { MessageBox }) {
    Vue.prototype.$deleteDialog = (option) => {
      const dialogOption = Object.assign(
        {
          title: '你确定吗？',
          message: '记录将被删除',
          callback: null,
          promptLabel: '',
          promptValue: '',
        },
        option
      )

      if (dialogOption.promptValue.length > 0) {
        MessageBox.prompt(
          '<h3>' +
            dialogOption.title +
            '</h3><div class="message">' +
            dialogOption.message +
            '</div>',
          {
            showClose: false,
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            iconClass: 'el-icon-warning-outline',
            customClass: 'delete-dialog',
            dangerouslyUseHTMLString: true,
            center: false,
            callback: (action) => {
              if (action === 'confirm') {
                dialogOption.callback()
              }
            },
            inputPlaceholder: '' + dialogOption.promptLabel,
            inputValidator: (value) => {
              return dialogOption.promptValue === value
            },
            inputErrorMessage: dialogOption.promptLabel + '不匹配',
          }
        )
      } else {
        MessageBox.confirm(
          '<h3>' +
            dialogOption.title +
            '</h3><div class="message">' +
            dialogOption.message +
            '</div>',
          {
            showClose: false,
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            iconClass: 'el-icon-warning-outline',
            customClass: 'delete-dialog',
            dangerouslyUseHTMLString: true,
            center: false,
            callback: (action) => {
              if (action === 'confirm') {
                dialogOption.callback()
              }
            },
          }
        )
      }
    }
  },
}

export default DeleteDialog
