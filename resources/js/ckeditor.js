import {
    ClassicEditor,
    AccessibilityHelp,
    Autoformat,
    AutoImage,
    AutoLink,
    Autosave,
    BlockQuote,
    Essentials,
    FindAndReplace,
    Heading,
    ImageBlock,
    ImageInline,
    ImageInsert,
    ImageInsertViaUrl,
    ImageTextAlternative,
    ImageToolbar,
    ImageUpload,
    // Indent,
    // IndentBlock,
    Italic,
    Link,
    List,
    ListProperties,
    MediaEmbed,
    Paragraph,
    SelectAll,
    SimpleUploadAdapter,
    SourceEditing,
    TextTransformation,
    Undo
} from 'ckeditor5';

import translations from 'ckeditor5/translations/ja.js';

import 'ckeditor5/ckeditor5.css';

if (document.getElementById('editor')) {

    document.addEventListener('DOMContentLoaded', () => {

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const editorConfig = {
            toolbar: {
                items: [
                    'undo',
                    'redo',
                    '|',
                    'sourceEditing',
                    'findAndReplace',
                    '|',
                    'heading',
                    '|',
                    'italic',
                    '|',
                    'link',
                    'insertImage',
                    'mediaEmbed',
                    'blockQuote',
                    '|',
                    'bulletedList',
                    'numberedList'//,
                    // 'outdent',
                    // 'indent'
                ],
                shouldNotGroupWhenFull: false
            },
            plugins: [
                AccessibilityHelp,
                Autoformat,
                AutoImage,
                AutoLink,
                Autosave,
                BlockQuote,
                Essentials,
                FindAndReplace,
                Heading,
                ImageBlock,
                ImageInline,
                ImageInsert,
                ImageInsertViaUrl,
                ImageTextAlternative,
                ImageToolbar,
                ImageUpload,
                // Indent,
                // IndentBlock,
                Italic,
                Link,
                List,
                ListProperties,
                MediaEmbed,
                Paragraph,
                SelectAll,
                SimpleUploadAdapter,
                SourceEditing,
                TextTransformation,
                Undo,
            ],
            heading: {
                options: [
                    {
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    // {
                    // 	model: 'heading1',
                    // 	view: 'h1',
                    // 	title: 'Heading 1',
                    // 	class: 'ck-heading_heading1'
                    // },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: '見出し', //'Heading 2',
                        class: 'ck-heading_heading2'
                    },
                    // {
                    // 	model: 'heading3',
                    // 	view: 'h3',
                    // 	title: 'Heading 3',
                    // 	class: 'ck-heading_heading3'
                    // },
                    // {
                    // 	model: 'heading4',
                    // 	view: 'h4',
                    // 	title: 'Heading 4',
                    // 	class: 'ck-heading_heading4'
                    // },
                    // {
                    // 	model: 'heading5',
                    // 	view: 'h5',
                    // 	title: 'Heading 5',
                    // 	class: 'ck-heading_heading5'
                    // },
                    // {
                    // 	model: 'heading6',
                    // 	view: 'h6',
                    // 	title: 'Heading 6',
                    // 	class: 'ck-heading_heading6'
                    // }
                ]
            },
            image: {
                toolbar: ['imageTextAlternative']
            },
            language: 'ja',
            link: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                decorators: {
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            simpleUpload: {
                // The URL that the images are uploaded to.
                uploadUrl: '/ckeditor/upload',

                // Enable the XMLHttpRequest.withCredentials property.
                withCredentials: true,

                // Headers sent along with the XMLHttpRequest to the upload server.
                headers: {
                    'X-CSRF-TOKEN': csrfToken, // CSRFトークン
                    Authorization: 'Bearer ' + localStorage.getItem('token') // ローカルストレージからJWTを取得
                }
            },
            placeholder: '記事を書いてください',
            translations: [translations]
        };

        ClassicEditor.create(document.querySelector('#editor'), editorConfig)
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(error => {
                console.error('There was a problem initializing the editor', error);
            });

    });

}