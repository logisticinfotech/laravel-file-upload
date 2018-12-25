In Laravel when uploading files sometime getClientOriginalExtension() returns empty string .


The getClientOriginalExtension() method returns the original file extension.
It is extracted from the original file name that was uploaded. Then it should not be considered as a safe value.

Input::file('File')->getClientOriginalExtension();
We should use guessExtension() method for resolution.

The guessExtension() method returns the extension based on the mime type.

This method uses the mime type as guessed by getMimeType() to guess the file extension.


Input::file('File')->guessExtension();
We think above solution worked for everyone who have this problem. We hope you find this blog helpful and if you have any questions or feedback feel free to add comment below this content.
