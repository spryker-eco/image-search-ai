import './search-by-image.scss';
import register from 'ShopUi/app/registry';

export default register(
    'search-by-image',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "search-by-image" */
            './search-by-image'
            ),
);
