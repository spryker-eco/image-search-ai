import Component from 'ShopUi/models/component';

const TIMEOUT = 15000;
export default class SearchByImage extends Component {
    protected dialog: HTMLDialogElement;
    protected fileInputField: HTMLInputElement[];
    protected loadingFrame: HTMLDivElement;
    protected closeButton: HTMLButtonElement;
    protected openButton: HTMLButtonElement[];
    protected serviceMessage: HTMLDivElement;
    protected form: HTMLFormElement;

    protected init(): void {
        this.dialog = this.querySelector(`.${this.jsName}__dialog`) as HTMLDialogElement;
        this.fileInputField = Array.from(this.querySelectorAll(`.${this.jsName}__file-input`)) as HTMLInputElement[];
        this.loadingFrame = this.querySelector(`.${this.jsName}__loading-frame`) as HTMLDivElement;
        this.closeButton = this.querySelector(`.${this.jsName}__close-button`) as HTMLButtonElement;
        this.openButton = Array.from(
            document.querySelectorAll(`.js-image-search-ai__button--image-search`),
        ) as HTMLButtonElement[];
        this.serviceMessage = this.querySelector(`.${this.jsName}__service-message`) as HTMLDivElement;
        this.form = this.querySelector(`.${this.jsName}__form`) as HTMLFormElement;
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.fileInputField?.map((field) => {
            field.addEventListener('change', (event) => this.onFileInputChange(event));
        });
        this.openButton?.map((button) => {
            button.addEventListener('click', () => {
                this.dialog.showModal();
            });
        });
        this.closeButton?.addEventListener('click', () => this.dialog.close());
    }

    protected onFileInputChange(event): void {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = (event) => {
                this.displayImagePreview(event.target.result as string);
            };

            reader.readAsDataURL(file);
        }
    }

    protected displayImagePreview(imageUrl: string): void {
        const imgPlaceholder = document.querySelector(`.${this.jsName}__image-placeholder`) as HTMLImageElement;
        imgPlaceholder.src = imageUrl;
        this.loadingFrame.classList.add(`${this.name}__loading-frame--active`);
        this.sendRequest(imageUrl);
    }

    protected async sendRequest(imageCode) {
        setTimeout(() => {
            this.loadingFrame.classList.remove(`${this.name}__loading-frame--active`);
            this.showServiceMessage();
        }, TIMEOUT);
        fetch(`${this.form.getAttribute('action')}`, {
            method: this.form.getAttribute('method'),
            signal: AbortSignal.timeout(TIMEOUT),
            body: JSON.stringify({ image: imageCode }),
        })
            .then((response) => response.json())
            .then((data) => {
                window.location.href = data.firstMatchProductUrl;
            })
            .catch(() => {
                this.loadingFrame.classList.remove(`${this.name}__loading-frame--active`);
                this.showServiceMessage();
            });
    }

    protected showServiceMessage(): void {
        this.serviceMessage.classList.remove('is-hidden');
    }
}
