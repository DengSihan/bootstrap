export default{
    data() {
        return {
            prevHeight: 0,
            transitionName: 'fade'
        };
    },
    methods: {
        beforeLeave(el) {
            this.prevHeight = getComputedStyle(el).height;
        },
        enter(el) {
            const { height } = getComputedStyle(el);
            el.style.height = this.prevHeight;
            setTimeout(() => {
                el.style.height = height;
            }, 0);
        },
        afterEnter(el) {
            el.style.height = 'auto';
        }
    }
}
