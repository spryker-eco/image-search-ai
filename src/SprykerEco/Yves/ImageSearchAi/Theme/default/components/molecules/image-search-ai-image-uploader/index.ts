import register from 'ShopUi/app/registry';
import './image-search-ai-image-uploader.scss';

export default register(
    'eco-image-uploader',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "image-search-ai-image-uploader" */
            './image-search-ai-image-uploader'
            ),
);
