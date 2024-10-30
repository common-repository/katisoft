const { registerBlockType } = wp.blocks;

registerBlockType('katisoft/custom-cta', {
    title: 'Call to Action',
    description: 'Custom CTA',
    icon: 'format-image',
    category: 'layout',

    attributes: {
        author: {
            type: 'string'
        }
    },

    edit({ attributes, setAttributes }) {
        //custom attributes
        function updateAuthor(event) {
            setAttributes( { author: event.target.value } );
        }

        return <input value={ attributes.author } onChange={ updateAuthor } type="text" />;
    },

    save({ attributes }) {
        return <div>Author Name: <i>{ attributes.author }</i></div>;
    }
})