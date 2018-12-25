In Laravel when uploading files sometime getClientOriginalExtension() returns empty string.

The getClientOriginalExtension() method returns the original file extension.
It is extracted from the original file name that was uploaded. Then it should not be considered as a safe value.

We should use guessExtension() method for resolution.

The guessExtension() method returns the extension based on the mime type.
