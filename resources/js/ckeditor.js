import { ClassicEditor, Essentials, Italic, Paragraph, ParagraphButtonUI, List, ListProperties , Heading, HeadingButtonsUI } from 'ckeditor5';

import 'ckeditor5/ckeditor5.css';

document.addEventListener('DOMContentLoaded', () => {
    ClassicEditor
        .create(document.querySelector('#editor'), {
            plugins: [Essentials, Italic, Paragraph, ParagraphButtonUI, List, ListProperties, Heading, HeadingButtonsUI],
            toolbar: [
                'undo', 'redo', '|',
                'paragraph', 'italic', '|',
                // 'heading1',
                 'heading2', '|',
                'bulletedList', 'numberedList'
            ],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    // { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                ]
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            }
        })
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('There was a problem initializing the editor', error);
        });

});