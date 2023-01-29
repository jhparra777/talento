<style>
    .video-upload {
        background-color: #ffffff;
        width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    @media (max-width: 991px) {
        .video-upload {
            width: 354px;
        }

        .file-upload-image {
            width: 354px;
        }
    }

    @media (max-width: 500px) {
        .video-upload {
            width: 300px;
        }

        .file-upload-image {
            width: 354px;
        }
    }

    @media (max-width: 440px) {
        .video-upload {
            width: 280px;
        }

        .file-upload-image {
            width: 354px;
        }
    }

    @media (max-width: 400px) {
        .video-upload {
            width: 255px;
        }

        .file-upload-image {
            width: 354px;
        }
    }

    @media (max-width: 340px) {
        .video-upload {
            width: 205px;
        }

        .file-upload-image {
            width: 200px;
        }
    }

    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100% !important;
        height: 100% !important;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-content {
        display: none;
        text-align: center;
    }

    /* Drag and drop zone */
    .image-upload-wrap {
        margin-top: 20px;
        border: 3px dashed #b3b3b3;
        position: relative;
        transition: all 300ms ease;
    }

    .image-dropping, .image-upload-wrap:hover {
        background-color: #b3b3b3;
        border: 3px dashed #ffffff;
    }

    .drag-text {
        font-weight: 500;
        font-size: 1.5rem;
        text-transform: uppercase;
        color: black;
        padding: 60px 0;
    }
    
    /* Preview video */
    .file-upload-image {
        max-width: 480px;
        max-height: 320px;
        margin: auto;
        padding: 20px;
    }
</style>