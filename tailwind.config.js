module.exports = {
    content: [
        './resources/views/widgets/_content.blade.php',
    ],
    theme: {
        extend: {
            typography: {
                'statamic-sticky-notes': {
                    css: {
                        fontSize: '0.875rem',
                        lineHeight: '1.25rem',
                        maxWidth: '100%',
                        h1: {
                            marginTop: '0.4em',
                            marginBottom: '0.8em',
                        },
                        h2: {
                            marginTop: '1.2em',
                            marginBottom: '0.8em',
                        },
                        h3: {
                            marginTop: '1.2em',
                            marginBottom: '0.6em',
                        },
                        li: {
                            marginBottom: '0',
                            marginTop: '0',
                            '> p': {
                                marginTop: '0.5rem !important',
                                marginBottom: '0.5rem !important'
                            }
                        },
                        'ul ul': {
                            marginBottom: '0 !important',
                            marginTop: '0 !important'
                        }
                    },
                },
            }

        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ]
}
