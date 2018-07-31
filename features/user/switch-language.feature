@registration

Feature: Test Switch Language
  Scenario:
    Given I am on "/"
    Then I should be on "/us/login"
    When I follow "Switch Language"
    Then I should be on "/us/choose-language"
    And I follow "Deutsch (German)"
    Then I should be on "/de/login"
