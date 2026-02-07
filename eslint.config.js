import prettier from 'eslint-config-prettier/flat';
import vue from 'eslint-plugin-vue';

import { defineConfigWithVueTs, vueTsConfigs } from '@vue/eslint-config-typescript';

export default defineConfigWithVueTs(
    vue.configs['flat/recommended'],
    vueTsConfigs.recommended,
    {
        ignores: ['vendor', 'node_modules', 'public', 'bootstrap/ssr', 'tailwind.config.ts', 'resources/ts/actions'],
    },
    {
        rules: {
            'vue/multi-word-component-names': 'off',
            'vue/no-v-html': 'off',
            '@typescript-eslint/no-explicit-any': 'off',
        },
    },
    prettier,
);
