<template>
    <div>
        <el-upload
            class="avatar-upload"
            :disabled="uploadOptions.url === ''"
            :action="uploadOptions.url"
            :accept="'image/*'"
            :show-file-list="false"
            :http-request="httpRequest"
            :before-upload="handleBeforeUpload"
            :on-success="handleSuccess"
            :on-error="handleError"
        >
            <img v-if="avatarUrl" alt="头像" :src="avatarUrl" class="avatar" />
            <i v-else class="el-icon-plus avatar-upload-icon" />
        </el-upload>
        <image-cropper
            v-if="cropperImage !== ''"
            :image="cropperImage"
            :crop-url="uploadOptions.cropUrl"
            :aspect-ratio="1"
            :cropper-size="[200, 200]"
            @on-cancel="handleImageCropperCancel"
            @on-success="handleImageCropperSuccess"
        />
    </div>
</template>

<script>
import flatry from "@core/utils/flatry";
import Request from "@core/utils/request";
import ImageCropper from "@admin/components/ImageCropper";

export default {
    name: "AvatarUpload",
    components: { ImageCropper },
    props: {
        avatar: {
            type: String,
            default: ""
        },
        filenameHash: {
            type: String,
            default: "random"
        }
    },
    data() {
        return {
            timer: null,
            avatarUrl: this.avatar,
            cropperImage: "",
            uploadOptions: {
                url: "",
                cropUrl: "",
                timeout: 0,
                params: [],
                headers: [],
                dataType: "",
                paramName: "",
                imageProcess: "",
                responseParse: ""
            }
        };
    },
    async mounted() {
        await this.getUrl();
    },
    beforeDestroy() {
        if (this.timer != null) {
            clearInterval(this.timer);
        }
    },
    methods: {
        async getUrl() {
            const { data } = await flatry(
                this.$http.get("misc/avatar-upload-options")
            );

            if (data) {
                this.uploadOptions = data;

                if (data.timeout && data.timeout > 0) {
                    this.timer = setTimeout(this.getUrl, data.timeout * 1000);
                }
            }
        },
        httpRequest(option) {
            const request = new Request({
                baseUrl: option.action,
                withCredentials: option.withCredentials,
                successHandler: response => {
                    option.onSuccess(response.data);
                },
                errorHandler: error => option.onError(error)
            });

            const headers = this.uploadOptions.headers;

            if (headers && Array.isArray(headers)) {
                request.httpClient.interceptors.request.use(config => {
                    for (let key in headers) {
                        config.headers[key] = headers[key];
                    }

                    return config;
                }, undefined);
            }

            const params = this.uploadOptions.params;

            const formData = new FormData();

            if (params) {
                for (let key in params) {
                    const value = params[key];
                    // eslint-disable-next-line no-template-curly-in-string
                    if (value.toString().indexOf("${filename}") !== -1) {
                        let randomFileName = "";

                        if (this.filenameHash === "original") {
                            randomFileName =
                                Math.random()
                                    .toString(36)
                                    .slice(-8) +
                                "_" +
                                option.file.name;
                        } else {
                            randomFileName =
                                Math.random()
                                    .toString(36)
                                    .substring(2, 16) +
                                "_" +
                                Math.random()
                                    .toString(36)
                                    .substring(2, 16) +
                                "." +
                                option.file.name.split(".").pop();
                        }

                        // eslint-disable-next-line no-template-curly-in-string
                        formData.append(
                            key,
                            value
                                .toString()
                                .replace("${filename}", randomFileName)
                        );
                    } else {
                        formData.append(key, value);
                    }
                }
            }

            formData.append(
                this.uploadOptions.paramName,
                option.file,
                option.file.name
            );

            request.post(option.action, formData);
        },
        handleBeforeUpload(file) {
            if (file.size > 1024 * 1024) {
                this.$message({
                    type: "error",
                    message: "你选择的文件大小超出上传限制",
                    duration: 1500
                });

                return false;
            }

            return true;
        },
        handleSuccess(response) {
            let result = "";

            if (this.uploadOptions.dataType === "xml") {
                result = new DOMParser().parseFromString(
                    response,
                    "application/xml"
                );
            } else {
                result = response;
            }

            // eslint-disable-next-line no-new-func
            const responseParse = new Function(
                "result",
                this.uploadOptions.responseParse
            );

            const url = responseParse(result);

            if (url) {
                const avatarUrl =
                    url +
                    (this.uploadOptions.imageProcess !== ""
                        ? this.uploadOptions.imageProcess + "avatar"
                        : "");

                if (
                    this.uploadOptions.cropUrl &&
                    this.uploadOptions.cropUrl !== ""
                ) {
                    this.cropperImage = avatarUrl;
                } else {
                    this.avatarUrl = avatarUrl;
                    this.$emit("on-upload-success", avatarUrl);
                }
            }
        },
        handleError(error) {
            const message =
                error.response.data.detail ||
                error.response.data.title ||
                error.response.data.message ||
                error.response.statusText ||
                error.message;

            this.$message({
                type: "error",
                message: message,
                duration: 1500
            });
        },
        handleImageCropperSuccess(url) {
            this.cropperImage = "";
            this.avatarUrl = url;
            this.$emit("on-upload-success", url);
        },
        handleImageCropperCancel() {
            this.cropperImage = "";
        }
    }
};
</script>
<style lang="scss">
.avatar-upload .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 3px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.avatar-upload .el-upload:hover {
    border-color: #409eff;
}

.avatar-upload-icon {
    font-size: 16px;
    color: #8c939d;
    width: 90px;
    height: 90px;
    line-height: 90px;
    text-align: center;
}

.avatar {
    width: 90px;
    height: 90px;
    display: block;
}
</style>
