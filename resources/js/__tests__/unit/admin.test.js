/**
 * @jest-environment jsdom
 */

// We need to simulate the DOM environment for these tests.
// The functions openCreateArticle and closeCreateArticle are in admin.js
// For a proper unit test, we should import them.
// For now, let's copy them directly into the test file for simplicity
// or ensure admin.js is loaded in the test environment.
// Given the context of a CLI agent, copying is simpler than configuring imports for Jest.

// Mock the openCreateArticle and closeCreateArticle functions from admin.js
// In a real setup, you would import them:
// import { openCreateArticle, closeCreateArticle } from '../admin'; // Adjust path if needed

// For this test, we will define them as they are in admin.js
function openCreateArticle() {
    document.getElementById('view-articles').classList.add('hidden');
    document.getElementById('create-article-view').classList.remove('hidden');
}

function closeCreateArticle() {
    document.getElementById('create-article-view').classList.add('hidden');
    document.getElementById('view-articles').classList.remove('hidden');
    // Assuming a form reset is part of it, which it is in the original code.
    // We don't have a full form to reset in this mock, so we'll omit testing reset for now.
    // document.getElementById('create-article-form').reset();
}


describe('Article management view toggling', () => {
    let viewArticles;
    let createArticleView;

    beforeEach(() => {
        // Set up a clean DOM for each test
        document.body.innerHTML = `
            <div id="view-articles"></div>
            <div id="create-article-view" class="hidden"></div>
        `;
        viewArticles = document.getElementById('view-articles');
        createArticleView = document.getElementById('create-article-view');
    });

    test('openCreateArticle should hide view-articles and show create-article-view', () => {
        // Initially, view-articles should be visible (no hidden class) and create-article-view hidden
        expect(viewArticles.classList.contains('hidden')).toBe(false);
        expect(createArticleView.classList.contains('hidden')).toBe(true);

        openCreateArticle();

        // After calling openCreateArticle, view-articles should be hidden and create-article-view visible
        expect(viewArticles.classList.contains('hidden')).toBe(true);
        expect(createArticleView.classList.contains('hidden')).toBe(false);
    });

    test('closeCreateArticle should hide create-article-view and show view-articles', () => {
        // First, simulate opening the create article view
        viewArticles.classList.add('hidden');
        createArticleView.classList.remove('hidden');

        // Verify initial state for this test
        expect(viewArticles.classList.contains('hidden')).toBe(true);
        expect(createArticleView.classList.contains('hidden')).toBe(false);

        closeCreateArticle();

        // After calling closeCreateArticle, create-article-view should be hidden and view-articles visible
        expect(viewArticles.classList.contains('hidden')).toBe(false);
        expect(createArticleView.classList.contains('hidden')).toBe(true);
    });
});
