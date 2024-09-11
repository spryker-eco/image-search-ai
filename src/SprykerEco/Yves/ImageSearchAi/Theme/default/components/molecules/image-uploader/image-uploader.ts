import Component from 'ShopUi/models/component';

export default class ImageUploader extends Component {
    protected timeout = 15000;
    protected fields: HTMLInputElement[];
    protected states = {
        loading: 'is-loading',
        empty: 'is-empty',
        error: 'is-error',
    }

    protected readyCallback(): void { }
    protected init(): void {
        this.fields = [...this.querySelectorAll<HTMLInputElement>(`.${this.jsName}__file-input`)];

        this.mapEvents();
    }

    protected mapEvents(): void {
        this.classList.remove(this.states.error, this.states.loading, this.states.empty);

        this.fields.forEach((field) => {
            field.addEventListener('change', this.onFileInputChange.bind(this));
        });
    }

    disconnectedCallback(): void {
        this.fields.forEach((field) => {
            field.removeEventListener('change', this.onFileInputChange.bind(this));
        });
    }

    protected onFileInputChange(event: Event): void {
        const file = ((event.target as HTMLInputElement).files as FileList)[0];
        const reader = new FileReader();

        reader.onload = (event) => {
            const src = event.target.result.toString();
            const image = this.querySelector<HTMLImageElement>(`.${this.jsName}__image-placeholder`);

            if (image) {
                image.src = src;
            }

            this.normalizeImage(src, this.sendRequest.bind(this));
        };

        reader.readAsDataURL(file);
    }

    protected normalizeImage(src: string, callback: (image: string) => void): void {
        const image = new Image();

        image.onload = () => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            canvas.width = image.width;
            canvas.height = image.height;

            ctx.drawImage(image, 0, 0);

            callback(canvas.toDataURL('image/png'));
        };

        image.src = src;
    }

    protected async sendRequest(image: string): Promise<void> {
        this.classList.remove(this.states.error, this.states.empty);
        this.classList.add(this.states.loading);

        try {
            const data = await (await fetch(this.action, {
                method: 'POST',
                signal: AbortSignal.timeout(this.timeout),
                body: JSON.stringify({ image, _token: this._token }),
            })).json();

            if (data.success) {
                this.classList.add(this.states.error);

                return;
            }

            if (!data?.firstMatchProductUrl) {
                this.classList.add(this.states.empty);

                return;
            }

            window.location.href = data.firstMatchProductUrl;
        } catch (error) {
            this.classList.add(this.states.error);
        } finally {
            this.classList.remove(this.states.loading);
        }
    }

    protected get action(): string {
        return this.getAttribute('action');
    }

    protected get _token(): string {
        return this.getAttribute('_token');
    }
}
